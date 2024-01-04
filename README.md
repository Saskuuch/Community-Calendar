Title:
Community Calendar

Description:
Community Calendar is a webapp created for COMP 3540 (Advanced Web Development) at Thompson Rivers University during the 2023 Fall Semester. It is intended to be a public calendar that anyone can post events to, though is mainly intended for clubs and societies. The webapp allows users to create and edit an account, as well as view, create, and save events. 
From a technical perspective, the project uses a model-view-controller framework to handle events and navigation.

Languages Used:
View - HTML, Javascript (including JQuery, JSON, and AJAX), CSS (including Bootstrap 5)
Model - PHP (including JSON), MySQL
Controller - PHP (including JSON)

Key Learning Points:
MVC architecture. The main concept of this course was the use of the MVC architecture using PHP. As such, all the files are PHP files, with all navigation being handeled server-side rather than wih hyperlinks. Database access is handeled entirely by the model files (modal.php and calendarfunctions.php), with navigation access to the model being handeled by the controller (controller.php).

Databases. This was my second time working with databases and first time using MySQL. I learned a lot of the basics of SQL-based languages. This was the first time I used a database hosted on a server and found that it was much more effective than locally hosted databases.

Challenges:
When creating this project, the biggest challenge I found was sticking to the MVC architecture. All the websites I've made up to this point where single-page websites that did not have any back-end, so it was very tempting to use hyperlinks for navigation. MVC was also challenging as it sometimes necessitated creating functions to handle the transfer of data between each component, which can be tedious compared to just accessing the data where it's being used.

Areas of Possible Improvement:
The main area I would try to improve for this project would be more functionality. I would like to add official users which would be things like city councils or registered clubs to allow users to filter out potential scams and unwanted events. Some more minor areas of improvement would be to remove past events after a certain period of time, add the ability to move between months on the calendar, and the ability to set an event to reacur every period of time.
