# PHP-backdoors
A collection of PHP backdoors. For educational and/or testing purposes only.


### Notes
* The [deobfuscated folder](Deobfuscated) does not necessarily contain deobfuscated versions of the backdoors you can find in the [obfuscated folder](Obfuscated). To deobfuscate those and other tricks, Check out the [PHP tools](PHP%20tools.md) section.
* Always investigate malware in a secure environment. This means: separately from your network and in a virtual machine!
* Some backdoors may be backdoored *(yes, really)*. Don't ever use this for any malicious purposes.
* The backdoors follow the format: *Backdoorname_SHA1.php*, granted the name of the backdoor is known.

### PHP tools
This includes links to tools for the following:
* Deobfuscators (online and offline)
* Beautifiers (online and offline)
* Testers (running the code - do this in a secure environment!)

Access the links to these tools directly from [here](PHP%20tools.md).


#### Other repos
* [webshell](https://github.com/tennc/webshell) - *This is a webshell open source project.*
* [php-exploit-scripts](https://github.com/mattiasgeniar/php-exploit-scripts/) - *A collection of PHP exploit scripts, found when investigating hacked servers.*
* [php-webshells](https://github.com/JohnTroony/php-webshells) - *Common php webshells.*
* [WebShell](https://github.com/tdifg/WebShell) - *WebShell Collect.*
* [webshellSample](https://github.com/tanjiti/webshellSample) - *Webshell sample for WebShell Log Analysis.*



#### Other information
Read my blog post on '[C99Shell not dead](https://bartblaze.blogspot.com/2015/03/c99shell-not-dead.html)' for more information about PHP backdoors (and in particular *c99Shell*, which you can also find in this repository). You can also follow me on [Twitter](https://twitter.com/bartblaze).


#### Detection
If you're trying to detect webshells like the ones mentioned in this repository, you may want to use [Yara](https://github.com/VirusTotal/yara) and scan your web server with the following Yara rules specifically for webshells:
[Yara-Rules/webshells](https://github.com/Yara-Rules/rules/tree/master/webshells)

Alternatively, have a look at the [disinfection tips](https://bartblaze.blogspot.com/2015/03/c99shell-not-dead.html#disinfection) provided in my blog post.



# License
[![License](http://i.imgur.com/9811oXC.png?2)](https://creativecommons.org/publicdomain/zero/1.0/)

To the extent possible under law, [bartblaze](https://github.com/bartblaze) has waived all copyright and related or neighboring rights to this work. He makes no warranties about the work, and disclaims liability for all uses of the work.
