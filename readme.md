# hp-default-wordpress
Welcome to the default WordPress install for Hensel Phelps!

Prerequisites:
--------------
- Decide on a name for your app, and get the corresponding app service deployed into Azure

Get started:
------------
1. Fork this repo to the name of your app (els18, supplier-diversity, arb-sccp, etc)
2. Clone the forked repo to your local machine
3. Set up azure remote: `git remote add azure https://<username>@<appname>.scm.azurewebsites.net/<appname>.git`
4. Make whatever edits you want to the local copy of the app (add/edit files, add plugins/themes, etc)
5. Commit all your changes `git add .`, then `git commit -am "<describe changes here>"`
6. Backup changes to VSTS: `git push origin`
7. Deploy to Azure: `git push azure`
   a. Note that the first push will be slow, subsequent pushes will be faster
   b. If this is your first push to Azure, go to https://<appname>.azurewebsites.net/wp-admin to complete the WordPress install
8. Repeat steps 4-7 for the typical development cycle
