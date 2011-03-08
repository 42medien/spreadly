#!/usr/bin/env ruby
LOGGING_THRESHOLD = 10
RESTART_THRESHOLD = 100
LOGFILE = '/var/log/mongodb/mongo_connection_healing.log'

count = `netstat -ap | grep '.*CLOSE_WAIT.*mongod'`.lines.count

if count > LOGGING_THRESHOLD
  require 'rubygems'
  require 'mongo'
  status = Mongo::Connection.new("localhost", 27017, :timeout => 5).db('yiid').command('serverStatus' => 1)
  conn_count = status['connections']['current']
  
  msg = "#{Time.now.strftime("%Y-%m-%d %H:%M:%S")}: [#{count}|#{conn_count}|#{LOGGING_THRESHOLD}|#{RESTART_THRESHOLD}] [Cons in CW|Current Cons|Logging Threshold|Restart Threshold]"

  if count > RESTART_THRESHOLD
    msg += " -> Restarting MongoDB"
    #  `/etc/init.d/mongodb restart`
  end

  f = File.open(LOGFILE, 'a')
  f.puts(msg)
  f.close
end
