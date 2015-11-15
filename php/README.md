This folder is what should be on the server which will get us the information needed for our app. Once you setup an apache or similar server, change this "http://10.1.39.55/addon/notifier.php" to "http://IP/addon/notifier.php", this must be done twice in the my-addon/index.js file and once in the my-addon/data/panel.html page.

Once this is done, you are setup and you can run the server, and go ahead and setup the app.

We used python to extract and scrape data off of moodle with a running session managed with requests using cURL.
