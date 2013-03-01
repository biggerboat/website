# Bigger Boat

This is the repository for [BiggerBoat.nl](http://biggerboat.nl)

## What's Bigger Boat

We are a group of independent web developers, software engineers, technical consultants, creative coders, enthousiasts, individuals, friends and we are good company. 


### What's being build?

We are running a continuous integration (Jenkins) that runs this deploy script: 
    
    # copy live database details
    cp ~/biggerboat/wp-config.php ~/jobs/$JOB_NAME/workspace/
    
    echo "<!-- $BUILD_NUMBER / $BUILD_ID -->" >> wp-content/themes/biggerboat/footer.php
    
    # sync the bigger boat theme!
    rsync --recursive --checksum --progress --compress  wp-content/themes/biggerboat/ biggerboat@server.com:/home/biggerboat/web/domains/biggerboat.nl/www/wp-content/themes/biggerboat
    
    # sync the bigger boat plugin!
    rsync --recursive --checksum --progress --compress  wp-content/plugins/biggerboat-jobs/ biggerboat@server.com:/home/biggerboat/web/domains/biggerboat.nl/www/wp-content/plugins/biggerboat-jobs