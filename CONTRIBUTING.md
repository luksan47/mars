# Contributing guideline

## The basics

We use the [Laravel framework](https://laravel.com/docs/6.x/), to learn more about it, read the basics section of its documentation.
It's also good to check out the previous commits, to see how to implement that part or that. Might seem a lot first, but it's really easy,
thanks to Laravel.

## Development

For OS X, [Valet](https://laravel.com/docs/valet) gives a pretty smooth experience. Easy to download, easy to configure.

For Windows and Linux the project has an example [Laravel Homestead](https://laravel.com/docs/homestead) configuration which can be used for local development.

With these steps you should be able to run Mars on your machine:

1. Clone Mars: `git clone git@github.com:luksan47/mars.git`.
2. Install [Vagrant](https://www.vagrantup.com/) and [VirtualBox](https://www.virtualbox.org/). (Or other virtualization platforms supported by Vagrant. Don't forget to reconfigure the `provider` in the steps below if you do so.)
3. Follow the instructions in the [First steps](https://laravel.com/docs/homestead#first-steps) section.
4. Copy `.env.homesteadexample` to `mars/.env` and `Homestead.yaml.example` to `Homestead/Homestead.yaml`.
. Modify the `Homestead.yaml` file by changing `/your/local/path/to/mars`.
5. Create ssh keys to `~/.ssh/homestead_rsa.pub` and `~/.ssh/homestead_rsa`. (You can use something like `ssh-keygen -t rsa -b 4096 -C "your_email@example.com"`.)
6. On Windows add the `192.168.10.10  mars.local` host entry to `C:\Windows\System32\drivers\etc\hosts`.
7. Run `vagrant up`.
8. Get a console to the virtual machine with `vagrant ssh`.
   * In the project root (`cd /home/vagrant/mars`) run `composer install` and `php artisan migrate:fresh --seed`.
9. The project should be running at [mars.local](http://mars.local/).

The MySQL database listens on port 3306 in the virtual machine, 33060 is forwarded from the host. See credentials in `.env`.

We like to use [PHPStorm](https://www.jetbrains.com/phpstorm/) for development. You can get a free license if you are a student.
The project contains basic configuration for this IDE with the Homestead environment, just open the project root in PHPStorm.

You can even use XDebug with this setup. Turn on listening for remote debug connections in PHPStorm and use the [XDebug](https://xdebug.org) browser extension in your favourite browser.

### Printing

If you want to test or develop the components dealing with the actual printing, you will also need to `sudo apt install -y cups-client poppler-utils` (for `lp`, `lpstat`, `cancel`; and `pdfinfo` respectively). After that, run `crontab -e`, and - after selecting the editor - enter the following: `* * * * * php /home/vagrant/mars/artisan schedule:run >> /dev/null 2>&1`, then close the file. This is needed because the `printjobs:update` command, which queries the actual printing queue by calling `lpstat` and updates the database accordingly, is scheduled to run every minute, and that won't happen without the entry in the crontab.

If you have a CUPS server running on your machine, then you might want to use that for testing purposes. It's not even necessary that your computer is connected to a printer, it's enough if its CUPS daemon knows of at least one printer because scheduling print jobs, cancelling them, etc. is possible even if no printer is connected. The easiest way to enable the virtual machine to connect to your CUPS daemon is by opening an SSH tunnel: `vagrant ssh -- -N -R 5550:localhost:631`, this tunnel will listen for connections to port 5550 on the virtual machine and redirect them to `localhost:631` on your machine (631 is the port on which CUPS is listening on your machine - you might have to change it). Then you have to edit your `.env` file and set `PRINTING_SUBSYSTEM_ENABLED=true`, `PRINTER_NAME="a_printer_that_your_cups_daemon_knows"` (you can query the known printers by issuing `lpstat -p` or by going [here](http://localhost:631/printers/)), and `PRINTING_UTILITY_ARGS="-h localhost:5550"`. After that you should be able to submit print jobs and see them appear on the website and [here](http://localhost:631/jobs/).

If you don't have a CUPS server or you don't want to use your local one, then you need to install the `cups-daemon` package by issuing `sudo apt install cups-daemon`. Afterwards you need to add a new printer to CUPS, and modify the `.env` file accordingly. (This has yet to be tried.)

## Keep it minimal

The main problem with Urán 1.1 was its *reinventing the wheel* strategy. Laravel provides everything we need. Use it.
The other problem was the unnecessary features came before the most important ones. Therefore the now defined issues are minial, only
contain the necessary parts of the system. After these are done, we can change the world. But first, build it.

## Commiting

When you would like to make some change, assign an issue to yourself, only after that start working on it.
If there's no issue, create one, but remember the paragraph above. Keep it minimal. If something's not clear, ask your questions under the issue.
Feel free to create your own branch (if you are a contributor), or fork the repo.
When you are done with your changes, the commit message should be the Issue's title and it should be sent through a
Pull Request. Also, feel free to review already sent in changes. E.g.

```bash
# when you start working
git checkout masteryour_feature_branch
git pull
git checkout -b your_feature_branch

# add your changes

# when you are done
git add --all  # or only your changes
git commit # an editor comes up, the first line should look like: Issue #x: changed this and that
# add more information if needed
git fetch origin
git rebase origin/master # resolve conflicts if something comes up 
git push origin your_feature_branch

# open repo in your browser and you should see a Create PR option.
```

## Got any questions?

Find me, or write a mail to root at eotvos dot elte dot uh. (Last two letteres reversed.)
