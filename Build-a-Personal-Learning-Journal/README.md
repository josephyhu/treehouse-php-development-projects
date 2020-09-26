# Build a Personal Learning Journal
3rd Treehouse PHP Techdegree project.

## About
This project allows the user to post journal entries that gets added to the database called journal.db. The user can also edit and delete specific entries, and they can even delete all entries.

## Information About the Pages
### Home Page (index.php)
This page lists all the entries ordered first by date posted in descending order, then by time posted in descending order, and finally by {id} in descending order. It also has a search and delete all entries features, and it has pagination.

### Detail Page (detail.php?id={id})
This page displays a specific entry by {id}.

### Profile Page (profile.php)
This page lists the total number of Treehouse badges earned and the total points earned per category in descending order.

### New Entry Page (new.php)
This page allows the user to post new entries. The allowed fields are entry title, date posted, time posted, time spent learning, things learned, resources, and tags. The fields: title, date, time, time spent, and things learned are all required. The resources and tags fields are optional.

### Edit Entry Page (edit.php?id={id})
This page allows the user to edit a specific entry by {id}. It has the same required and optional fields as the new page.

### Tag Page (tags.php?tag={tag})
This page displays all entries by {tag} ordered first by date posted in descending order, then by time posted in descending order, and finally by {id} in descending order. It also has pagination.

### Delete and Delete All Pages (delete.php?id={id} and delete_all.php)
These pages delete a specific entry by {id} and all entries respectively.

### Pages with URLs Ending in `_l`
All pages with URLs ending in `_l` are exactly the same as the corresponding pages without the `_l` in the URL except they have lighter backgrounds.

## Recent Changes
* Added dark background/light background option.
* Added search field to the home page.
* Added pagination to the home and the tags pages with the current limit of 25 entries per page.
* Changed the delete link in the detail page to a button with a confirmation box on click.
* Added delete all entries button to the home page with a confirmation box on click.
* Added two links on either side of the copyright in the footer which sends the user to the top of the page.
* Now the entries on both home and tags pages are ordered first by date posted in descending order, then by time posted in descending order, and finally by id also in descending order.
* Added ability to enter time posted. Also now, the date and time defaults to current date and time (in UTC-05:00 or US/New York time) when adding a new post.
* Added a profile page that displays the total number of Treehouse badges earned and the total points earned per category in descending order.

## Things to Improve
1. Allow the user to set the current limit of entries per page from the following choices: 10, 25, 50, 100, and all.
   * Works on the first page, but does not work on subsequent pages.
1. ~Allow the user to change the background from light to dark and vice versa.~
1. Prevent the Next Page button from showing on the last page if there are exactly 25 (or whatever limit the user has set if (1) has been implemented) entries on that page. No problems if there are less than 25 (or whatever limit the user has set if (1) has been implemented) entries on the page.
1. Add comments to the code.
