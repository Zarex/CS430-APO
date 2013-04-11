CS430-APO
-----------

Scripts
-----------
browse.php event sign-up

Attendance/Service Hours Logger
	Log hours once they have been approved
		onto recorded_hours table
	Log attendance once attendance has been confirmed

Force users to update information at beginning of semester

Prompts pledges to update their information after initiation

Change Pledge->Active after activation - BW



DB
-----------


Pages			  
-----------

manage.php
	edit events
	modify next week

update_info.php The update information page

defaults.php The page where defaults can be changed
	(mentioned under DB)
	This dynamic page should display defaults that can be
		changed by the exec member that is viewing the page


Rules			  
-----------

public	view events from the current day
public 	view events for future days
			through curent week
leader 	view their past events
leader	record attendance for their events
leader  cancel their events
Creator has ability to set-up next week

Def: current week - 
	The current week cycles Mon-Sun

Def: next week -
	The next week can be set-up Mon-Fri

Events get published to public on Fri
