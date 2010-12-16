set :application, "yiid"
set :user, 'localadm'
set :use_sudo, false

set :repository,  "https://svn.ekaabo.com/yiid/trunk"
set :scm,         :subversion
set :scm_username, "christian.weyand"
set :scm_password, "c211-w656*1983"

set :deploy_directory, "/tmp/capistrano"

role :web,    "mario.obaake.com"                         # Your HTTP server, Apache/etc
#role :db,     "donkeykong.obaake.com", :primary => true  # This is where Rails migrations will run

set  :keep_releases,  5 

task :prod do
  set :sf_env, "prod"
  set :domain,      "yiid.com"
  set :deploy_to,   "#{deploy_directory}/#{domain}"
  set :deploy_via, :export
end

task :staging do
  set :sf_env, "staging"
  set :domain,      "yiiddev.com"
  set :deploy_to,   "#{deploy_directory}/#{domain}"
  set :deploy_via, :checkout
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

  desc "Customize migrate task to work with symfony."
  task :migrate do
    run "php #{latest_release}/symfony doctrine:migrate --env=#{sf_env}"
  end
  
  desc "We do not need to restart anything, so it was taken out."
  task :default do
    update
  end
  
  desc "This task is the main task of a deployment."
  task :update do
    transaction do
      update_code
      symlink
      symfony.cc
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
  
  namespace :yiid do

    desc "Build it."
    task :build do
      run "php #{latest_release}/symfony yiid:build --all --env=#{sf_env}"
    end
  end
end
