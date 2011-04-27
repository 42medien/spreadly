#!/usr/bin/env ruby
i=0
while true
 puts "Starting batch No. #{i+=1}\n--------------------------------------------------\n"
 result = `php migrateCommunity.php`
 puts result
 puts "\n"
 break if result.match(/PFEFFI_SAYS_ITS_DONE/) || i>1000
end