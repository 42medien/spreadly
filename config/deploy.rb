set :application, "yiid"
set :user, 'httpd'
set :use_sudo, false

set :repository,  "https://svn.ekaabo.com/yiid/"
set :scm,         :subversion
set :scm_username, "yiid"
set :scm_password, "yiidyiidyiid"

set :deploy_directory, "/home/httpd/vhosts"
set :current_dir, "httpdocs"

role :web,    "mario.obaake.com"                        # Your HTTP server, Apache/etc
role :button, "mario.obaake.com"                 # List of Button Instances, comma separated

set  :keep_releases,  5

task :prod do
  set :sf_env, "prod"
  set :domain,      "yiid.com"
  set :deploy_to,   "#{deploy_directory}/#{domain}"
  set :deploy_via, :export
  ask_for_repository
end

task :staging do
  set :sf_env, "staging"
  set :domain,      "yiiddev.com"
  set :deploy_to,   "#{deploy_directory}/#{domain}"
  set :deploy_via, :checkout
  puts "Deploying #{application} to #{domain} for env=#{sf_env} …"
  set :deploy_button, true
  ask_for_repository
end

# Symfony stuff

# Dirs that need to remain the same between deploys (shared dirs)
set :shared_children,   %w(log web/uploads)

namespace :deploy do
  desc "Overwrite the start task because symfony doesn't need it."
  task :start do ; end

  desc "Overwrite the restart task because symfony doesn't need it."
  task :restart do ; end

  desc "Overwrite the stop task because symfony doesn't need it."
  task :stop do ; end

  desc "Overwrite the migrate task because symfony doesn't need it."
  task :migrate do ; end

  desc "We do not need to restart anything, so it was taken out."
  task :default do
    update
    update_button if sf_env=='prod' || deploy_button
  end

  desc "This task is the main task of a deployment."
  task :update, :roles => :web do
    transaction do
      update_code
      symfony.yiid.set
      symfony.yiid.build
      symlink
    end
  end

  desc "This task is the main task of a deployment."
  task :update_button, :roles => :button do
    transaction do
      update_code
      symfony.yiid.set
      symfony.yiid.build_button
      symlink
    end
  end  

  desc "We do not need to restart anything, so it was taken out."
  task :migrations do
    update_code
    migrate
    symlink
  end

  desc "Symlink static directories and static files that need to remain between deployments."
  task :share_childs do
    if shared_children
      shared_children.each do |link|
        run "mkdir -p #{shared_path}/#{link}"
        run "if [ -d #{release_path}/#{link} ] ; then rm -rf #{release_path}/#{link}; fi"
        run "ln -nfs #{shared_path}/#{link} #{release_path}/#{link}"
      end
    end
  end

  desc "Customize the finalize_update task to work with symfony."
  task :finalize_update, :except => { :no_release => true } do
    run "mkdir -p #{latest_release}/cache"
    #run "chown -R httpd:httpd #{latest_release}"

    # Share common files & folders
    share_childs
  end

  desc "Need to overwrite the deploy:cold task so it doesn't try to run the migrations."
  task :cold do ; end
end

namespace :symfony do

  desc "Clear the cache."
  task :cc do
    run "php #{latest_release}/symfony cc --env=#{sf_env}"
  end

  desc "Disable the app."
  task :disable do
    run "php #{latest_release}/symfony project:disable #{sf_env}"
  end

  desc "Enable the app."
  task :enable do
    run "php #{latest_release}/symfony project:enable #{sf_env}"
  end

  namespace :yiid do
    desc "Set the release name and other stuff."
    task :set do
      run "php #{current_release}/symfony yiid:set --release-name=#{release_name} --env=#{sf_env}"
    end

    desc "Build the button."
    task :build_button do
      run "php #{current_release}/symfony yiid:build-button --env=#{sf_env}"
    end
    
    desc "Build it."
    task :build do
      command = "php #{latest_release}/symfony yiid:build --all --env=#{sf_env} --no-confirmation"

      do_it = Capistrano::CLI.ui.ask("Do you really want to do this:\n#{command}\nAnswer with (y|n)[n]: ")

      if do_it=='y'
        run command
      else
        puts "Skipping it"
      end
    end
  end
end

def ask_for_repository
  type = Capistrano::CLI.ui.ask("Checkout Trunk, Branch or Tag (trunk|branch|tag)[trunk]: ")

  if type == 'branch'
    set :repository, repository + 'branches/releases/'
  elsif type == 'tag'
    set :repository, repository + 'tags/'
  else
    set :repository, repository + 'trunk'
  end

  if ['branch', 'tag'].include? type
    name = Capistrano::CLI.ui.ask("Which name for #{repository}: ")
    set :repository, "#{repository}" + (name.strip.empty? ? default : name)
  end

  puts "Using repository: " + repository
end

