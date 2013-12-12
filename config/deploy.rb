set :application, 'yiid'
set :repo_url, 'https://spreadly:affen2010@github.com/ekaabo/spreadly.git'

set :branch, 'master'

set :scm, :git
set :user, "spreadly"
set :scm_passphrase, "affen2010"
set :git_https_username, :user
set :git_https_password, :scm_passphrase

set :format, :pretty
set :log_level, :debug
set :pty, true

set :forward_agent, true

# set :linked_files, %w{config/database.yml}
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}
set :linked_dirs, %w{web/uploads log}

# set :default_env, { path: "/opt/ruby/bin:$PATH" }
set :keep_releases, 5

namespace :symfony do
  desc "Clear the cache."
  task :permissions do
    on roles(:all) do
      execute "php #{current_path}/symfony project:permissions"
    end
  end

  desc "Clear the cache."
  task :cc do
    on roles(:all) do
      execute "php #{current_path}/symfony cc --env=#{fetch(:stage)}"
    end
  end

  desc "Disable the app."
  task :disable do
    on roles(:all) do
      execute "php #{current_path}/symfony project:disable #{fetch(:stage)}"
    end
  end

  desc "Enable the app."
  task :enable do
    on roles(:all) do
      execute "php #{current_path}/symfony project:enable #{fetch(:stage)}"
    end
  end

  namespace :yiid do
    desc "Build it."
    task :build do
      on roles(:all) do
        execute "php #{current_path}/symfony yigg:build --all --env=#{fetch(:stage)} --no-confirmation"
      end
    end

    task :build_button do
      on roles(:all) do
        execute "php #{current_path}/symfony yigg:build-button --all --env=prod --no-confirmation"
      end
    end
  end
end