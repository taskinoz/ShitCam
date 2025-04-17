# ShitCam

A motion dashboard for catching my cats shitting on the floor

## Setup

1. Install motion and set up the config file
2. Set the permissions for the output directory

```
sudo chmod -R 755 /var/lib/motion
sudo chown -R www-data:www-data /var/lib/motion  # For Apache/Nginx (adjust if needed)
```

3. Link the output directory to the web server directory

```
sudo ln -s /var/lib/motion /var/www/html/videos
```

4. Add the php files in the `src` directory to the web server directory
