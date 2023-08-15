# Explanation

# The problem
The client needs to list all the hyperlinks that are displayed on the homepage for SEO improvement.

# Technical specification
To solve the problem mentioned above, the plugin will be structured as follow:
* A backend admin area is needed for the user to initiate the crawling process. This area will contain a button to start the process, a button to view the results, and an area to display the results. If there are no results to display a message should be displayed.
* The plugin will extract all the hyperlinks inside the designated homepage content.
* Results will be saved on a temporary database that can be retrieved every time the user clicks on `view results`.
* Homepage's PHP file will be saved as an HTML file in a subfolder on the plugin's structure.
* The results will be saved in a html file as a sitemap list structure.

# Technical decisions
* Transient name and the route to display the sitemap will be defined as constants in the `crawl-home.php` file to make easier its editing through the site.
* To create a route for the user to view the sitemap on the frontpage will be used the `parse_request` action hook, so when the `site/home` query variable is parsed, it will supply the generated sitemap file content.
* If there is no page assigned as `front page`, the plugin will bring all the hyperlinks from the HTTP request of the homepage.
* Temporary results will be saved on transients to make use of the expiration time.
* The hyperlinks will be saved with the same name/title as on the homepage, so it will be easier for the user to find them inside the page to perform SEO strategies.

#  How it works
First, it renders the menu page in the admin area. It will display two buttons and the results if the request includes the `display-results` parameter.

When the crawling process starts, it will check if there is any page assigned as the `front page` to retrieve the content. If there isn't (for example when using a plain URL structure setting), will bring the current homepage data from an HTTP request. The downside to this fallback is that header and footer navigation menus will also be included in the crawling.

After retrieving the homepage content it will get an array of all the hyperlinks in the content and will filter them to exclude anchors and links to the homepage. Results will then be saved in the transient.

After the crawling is done it will create a homepage.html file with the content from the homepage and a sitemap.html with the results structured as a list. Both files will be located inside a subfolder `html`.

When all tasks are finished it will redirect the user to the plugin's admin area with the parameter `display-results` set to true so the results can be displayed in the admin area.

The created sitemap.html file can be accessed in the URL `/sitemap/home`.

# Conclusion
The solution proposed will let the admin extract all the hyperlinks located on the homepage and display them in the admin area, this will allow them to see how the internal web pages are linked on the homepage. They can also save the generated homepage.html and sitemap.html and use them in the future as historical records or as part of an A/B test.