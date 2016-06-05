I have developed mini web application which connects to Last.fm api to retrieve data.

You will need the php-environment-set-up to run the code. You can set it up in MAMP or Vagrant or any other services
you are familiar with.

There are no external packages used. PHP Last.fm API library is also not used hence there is no special installation required to run this code.

By default, the code search with country "spain". So Do not get surprise when you hit the page
for the first time and you see some results.

The search field uses angular.js to create country dropdown. When you search with any text, it will show you the list of country. Selected the country, and hit enter or click search button to see the results. Clicking on the thumbnail takes you to next page where it displays top 5 tracks of the artist. You can hit the link to listen the track.


