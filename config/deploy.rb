default_run_options[:pty] = true
set :application, "yiid"
set :use_sudo, false

set :repository,  "git@github.com:ekaabo/spreadly.git"
set :scm,         "git"
set :user, "spreadly"
set :scm_passphrase, "affen2010"
set :branch, "master"

role :web,    "spreadly.com"                        # Your HTTP server, Apache/etc
set :current_dir, "current"
ssh_options[:forward_agent] = true

set  :keep_releases,  5

task :prod do
  set :button_deployment, false
  set :user, 'root'
  set :sf_env, "prod"
  set :domain,      "spreadly.com"
  set :deploy_to,   "/var/www/spreadly.com"
  set :deploy_via, :export
  puts "Deploying #{application} to #{domain} for env=#{sf_env} …"
end

task :staging do
  set :button_deployment, false

  set :sf_env, "staging"
  set :domain,      "spreadly.ekaabo.crcl.ws"
  set :deploy_to,   "/mnt/data/spreadly/www/httpdocs"
  set :deploy_via, :checkout
  puts "Deploying #{application} to #{domain} for env=#{sf_env} …"
end

task :button do
  role :button, "ec2-79-125-32-228.eu-west-1.compute.amazonaws.com" # Prod
  set :user, 'root'

  set :button_deployment, true

  set :deploy_directory, "/var/www/button.spread.ly"
  set :current_dir, "current"

  set :sf_env, "prod"
  set :domain,      "button.spread.ly"
  set :deploy_to,   "#{deploy_directory}"
  set :deploy_via, :export
end

task :staging_button do
  role :button, "ec2-79-125-32-228.eu-west-1.compute.amazonaws.com" # Staging
  set :user, 'root'

  set :button_deployment, true

  set :deploy_directory, "/var/www/button.yiiddev.com"
  set :current_dir, "current"

  set :sf_env, "staging"
  set :domain,      "button.yiiddev.com"
  set :deploy_to,   "#{deploy_directory}"
  set :deploy_via, :checkout
end

# Symfony stuff

before "deploy:symlink", "deploy:stop_worker"
after "deploy:symlink", "deploy:start_worker"


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
    if button_deployment
      update_button
    else
      update
    end
  end

  desc "This task is the main task of a deployment."
  task :update do
    transaction do
      update_code
      symfony.yiid.set
      symfony.yiid.build
      # symfony.yiid.i18n_sync
      symlink
    end
  end

  desc "This task is the main task of a deployment."
  task :update_button do
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
    run "mkdir -p #{latest_release}/log"
    run "mkdir -p #{latest_release}/lib/mongo/Hydrators"
    run "mkdir -p #{latest_release}/lib/mongo/Proxies"
    run "chmod -R 777 #{latest_release}/cache"
    run "chmod -R 755 #{latest_release}/log"
    run "chmod -R 777 #{latest_release}/lib/mongo/Hydrators"
    run "chmod -R 777 #{latest_release}/lib/mongo/Proxies"

    # Share common files & folders
    share_childs
  end

  desc "Need to overwrite the deploy:cold task so it doesn't try to run the migrations."
  task :cold do ; end

  task :stop_worker do
    #surun "/etc/init.d/Worker-#{sf_env} stop"
  end

  task :start_worker do
    run "chmod 744 #{latest_release}/lib/Queue/Boss.php"
    #surun "/etc/init.d/Worker-#{sf_env} start"
  end

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
    task :build_button, :roles => :button do
      run "php #{current_release}/symfony yiid:build-button --env=#{sf_env}"
    end

    desc "Build the button."
    task :i18n_sync do
      run "php #{current_release}/symfony yiid:i18n-sync --env=#{sf_env} --no-confirmation"
    end

    desc "Build it."
    task :build, :roles => :web do
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

# Runs +command+ as root invoking the command with su -c
# and handling the root password prompt.
#
#   surun "/etc/init.d/apache reload"
#   # Executes
#   # su - -c '/etc/init.d/apache reload'
#
def surun(command)
  password = fetch(:root_password, Capistrano::CLI.password_prompt("root password: "))
  run("su - -c '#{command}'", :options => {:pty => true}) do |channel, stream, output|
    channel.send_data("#{password}n") if output
  end
end

