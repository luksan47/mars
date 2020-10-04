# Contributing guideline

## The basics

We use the [Laravel framework](https://laravel.com/docs/6.x/), to learn more about it, read the basics section of its documentation.
It's also good to check out the previous commits, to see how to implement that part or that. Might seem a lot first, but it's really easy,
thanks to Laravel.

## Development

For OS X, [Valet](https://laravel.com/docs/6.x/valet) gives a pretty smooth experience. Easy to download, easy to configure.

For Windows and Linux the project has an example [Laravel Homestead](https://laravel.com/docs/homestead) configuration which can be used for local development.

With these steps you should be able to run Mars on your machine:

1. Clone Mars: `git clone git@github.com:luksan47/mars.git`.
2. Install [Vagrant](https://www.vagrantup.com/) and [VirtualBox](https://www.virtualbox.org/). (Or other virtualization platforms supported by Vagrant. Don't forget to reconfigure the `provider` in the steps below if you do so.)
3. Follow the instructions in the [First steps](https://laravel.com/docs/8.x/homestead#first-steps) section.
4. Set up Homestead: Copy `Homestead.yaml.example` from this repo to `homestead.yaml` in the Homestead directory. Modify this file by changing `folders: - map: /your/local/path/to/mars` .
5. Set up Mars: Copy and rename `.env.example` to `.env`, and change these settings: 
`DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret`
If you want to set up emails, change `MAIL_TEST_ADMIN` to your email (after seeding, you will be able to log in to the admin user with this email address) and set your email credentials (`MAIL_USERNAME` and `MAIL_PASSWORD`) - you might have to enable third party access to your email account. 
5. Create ssh keys to `~/.ssh/homestead_rsa.pub` and `~/.ssh/homestead_rsa`. (You can use something like `ssh-keygen -t rsa -b 4096 -C "your_email@example.com"`.)
6. On Windows add the `192.168.10.10  mars.local` host entry to `C:\Windows\System32\drivers\etc\hosts`.
7. Go to your Homestead directory and Run `vagrant up` and `vagrant ssh` to set up and enter your virtual machine.
8.
   * In the project root (`cd mars`) run `composer install` and `php artisan migrate:fresh --seed`.
   * Run `php artisan key:generate`.
   * Run `npm install` to install JS related dependencies.
   * Run `npm run dev` to create the CSS and JS files in the `public` directory. 
9. The project should be running at [mars.local](http://mars.local/).

We like to use [PHPStorm](https://www.jetbrains.com/phpstorm/) for development. You can get a free license if you are a student.
The project contains basic configuration for this IDE with the Homestead environment, just open the project root in PHPStorm.

You can even use XDebug with this setup. Turn on listening for remote debug connections in PHPStorm and use the [XDebug](https://xdebug.org) browser extension in your favourite browser.

### For everyday use

Most of the above setup is a one-time thing to do. However, whenever you start working on based on a newer version, you will have to run the following commands:

 * `npm run dev`: In case of recent UI changes (ie. JS or CSS), this will generate the new assets from `webpack.mix.js`. For frontend developers, `npm watch` might be useful -- it does the same, but also updates on change.
 * `php artisan migrate:fresh --seed`: This will migrate everything from scratch (useful if you work on changes in parallel) and seeds the database.

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
