# hp-default-wordpress
Welcome to the default WordPress install for Hensel Phelps! Get started with a new site using the following steps:

Prerequisites:
--------------
- Decide on a name for your app, and get the corresponding app service deployed into Azure

1. Fork this repo to the name of your app (els18, supplier-diversity, arb-sccp, etc)
2. Clone the forked repo to your local machine
3. Set up azure remote: `git remote add azure https://<username>@<appname>.scm.azurewebsites.net/<appname>.git`
4. Make whatever edits you want to the local copy of the app (add/edit files, add plugins/themes, etc)
5. Commit all your changes `git add .`, then `git commit -am "<describe changes here>"`
6. Backup changes to VSTS: `git push origin`
7. Deploy to Azure: `git push azure` (the first push will be slow, subsequent pushes will be faster)
8. Repeat steps 4-6 for the typical development cycle
