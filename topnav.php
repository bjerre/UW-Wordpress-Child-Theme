<?php

include_once(ABSPATH.WPINC.'/feed.php'); // path to include script
$rss = fetch_feed('http://www.atmos.washington.edu/rss/home.rss'); // specify feed url
$weather = false;

if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
    
    // Figure out how many total items there are, but limit it to 3 
    $maxitems = $rss->get_item_quantity(3); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems);
    
    // pull the titles out of the $rss_items object and build an array of titles
    foreach ( $rss_items as $item ) :
    
		$weatherItems[] = $item->get_title();
	
	endforeach;
    
    $tempInfo = explode('|',$weatherItems[0]);
    $temp = substr($tempInfo[1],1);

    $condInfo = explode('|',$weatherItems[1]);
    $cond = substr($condInfo[1],1);

    $iconInfo = explode('|',$weatherItems[2]);
    $icon = substr($iconInfo[1],1);
    
    if (!empty($cond) && $icon !== '00') {
    	// Set the weather to true
    	$weather = true;
    }
    
endif;

?>

<div class="wheader patchYes colorGold">	
  <div id="autoMargin">
  
    <div class="wlogoSmall">
      <div class="logoAbsolute"><a id="wlogoLink" href="http://www.washington.edu/">University of Washington</a></div>
	</div>
	<?php if ($weather == true) : ?>
	<div id="weather">
	  <a href="http://www.atmos.washington.edu/weather/forecast.shtml"><img src="http://www.washington.edu/static/image/weather/<?php echo $icon; ?>.png" width="32" height="32" alt="<?php echo $cond; ?>: <?php echo $temp; ?>" title="<?php echo $cond; ?>: <?php echo $temp; ?>" class="weather-icon" /></a>
	  <div>
	    <span class="weather-city"><a href="http://www.atmos.washington.edu/weather/forecast.shtml" title="Click for a detailed forecast">Seattle</a> <?php echo $temp; ?></span>
	  </div>
	</div>
	<?php endif; ?>
	<div id="wtext">
    	<ul>
      		<li><a href="http://www.washington.edu/">UW Home</a></li>
        	<li><span class="border"><a href="http://www.washington.edu/home/directories.html">Directories</a></span></li>
       	  	<li><span class="border"><a href="http://www.washington.edu/discover/visit/uw-events">Calendar</a></span></li>
            <li><span class="border"><a href="http://www.lib.washington.edu/">Libraries</a></span></li>
       	  	<li><span class="border"><a href="http://www.washington.edu/maps/">Maps</a></span></li>
       	  	<li><span class="border margRight"><a href="http://myuw.washington.edu/">My UW</a></span></li>
            <li><a href="http://www.uwb.edu/">UW Bothell</a></li>
       	  	<li><span class="border"><a href="http://www.tacoma.washington.edu/">UW Tacoma</a></span></li>
       </ul>
   </div>
    
  </div>
</div>

<div id="visual-portal-wrapper">
      <div id="bg">
        <div id="header">  
        
        <span id="uwLogo"><a href="http://www.washington.edu/">University of Washington</a></span>	
        
        <div id="wsearch">
                <form action="http://www.google.com/cse" id="searchbox_001967960132951597331:04hcho0_drk" name="uwglobalsearch">
                  <div class="wfield">
                    <input type="hidden" value="001967960132951597331:04hcho0_drk" name="cx" />
                    <input type="hidden" value="FORID:0" name="cof" />
                    <input type="text" class="wTextInput" value="Search the UW" title="Search the UW" name="q" />
                  </div>
                  <input type="submit" value="Go" name="sa" class="formbutton" />
                </form>
            </div>
        
        	
        	<p class="tagline"><a href="http://www.washington.edu/discovery/washingtonway/"><span class="taglineGold">Discover what's next.</span> It's the Washington Way.</a></p>
        	
        	<ul id="navg">
   
    <li class="mainNavLinkLeft">
      <div class="mainNavLinkRight">
        <h4><a class="mainNavLinkNotch" href="http://depts.washington.edu/uwadv/">Home</a></h4><br class="clear" />

        <div class="text">
          <div class="mainNavBG">
            <ul class="mainNavLinks">
              <li><a href="https://depts.washington.edu/uwadv/advanced-search/">Advanced Search</a></li>
              <li><a href="https://depts.washington.edu/uwadv/directory/">Directory</a></li>
              <li><a href="https://depts.washington.edu/uwadv/staff-profiles/">Staff Profiles</a></li>
              <li><a href="https://depts.washington.edu/uwadv/consolidated-calendar/">Calendar</a></li>
            </ul>

            <div class="mainNavBlurb">
              <p><span><a href="http://www.washington.edu/discover/"><img alt=
              "Fountain and the Mountain" src=
              "http://www.washington.edu/images-library/fountain1.jpg" class=
              "image-inline" height="120" width="200" /></a><br />
              Founded in 1861, the University of Washington is one of the oldest
              state-supported institutions of higher education on the West Coast and is
              one of the preeminent research universities in the world. <a class=
              "internal-link" href="http://www.washington.edu/discover/"><span class=
              "internal-link">Learn more</span></a></span></p>
            </div><br class="clear" />
            <br class="clear" />
          </div>
        </div>
      </div>
    </li>

    <li class="mainNavLinkLeft">
      <div class="mainNavLinkRight">
        <h4><a class="mainNavLinkNotch" href="https://depts.washington.edu/uwadv/units-organizations/">Units & Organizations</a></h4><br class="clear" />

        <div class="text">
          <div class="mainNavBG">
            <ul class="mainNavLinks">
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/charts-list/">Org Charts & List</a></li>
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/vp/">Office of the Vice President</a></li>
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/exec/">Executive Group</a></li>
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/as/">Advancement Services</a></li>
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/acr/">Alumni & Constituent Relations</a></li>
              <li><a href="https://depts.washington.edu/uwadv/units-organizations/cp/">Constituency Programs</a></li>
              <li><a href="https://depts.washington.edu/uwadv/cfr/">Corporate & Foundation Relations</a></li>
              <li><a href="https://depts.washington.edu/uwadv/fa/">Finance & Administration</a></li>
              <li><a href="https://depts.washington.edu/uwadv/igp/">Individual Giving Programs</a></li>
              <li><a href="https://depts.washington.edu/uwadv/mkt/">UW Marketing</a></li>
              <li><a href="https://depts.washington.edu/uwadv/uwmed/">UW Medicine</a></li>           
            </ul>

            <div class="mainNavBlurb">
              <p><span><a href="http://www.hfs.washington.edu/newhuskycard/"><img src=
              "http://www.washington.edu/images-library/homepage-tabs/huskycard.jpg" alt=
              "Husky Card sample graphic" class="image-inline" height="119" width=
              "190" /></a><br />
              <b><a href="http://www.hfs.washington.edu/newhuskycard/">Introducing the
              new<br />
              Husky Card</a></b> The Husky Card is the official identification card for
              members of the UW community. It provides access to a variety of services
              and opportunities, including access to campus libraries. Learn about
              changes that are currently under way. <a class="external-link" href=
              "http://www.hfs.washington.edu/newhuskycard/">Details</a></span></p>
            </div><br class="clear" />
            <br class="clear" />
          </div>
        </div>
      </div>
    </li>

    <li class="mainNavLinkLeft">
      <div class="mainNavLinkRight">
        <h4><a class="mainNavLinkNotch" href="https://depts.washington.edu/uwadv/toolkits/">Toolkits     </a></h4><br class="clear" />

        <div class="text">
          <div class="mainNavBG">
            <ul class="mainNavLinks">
              <li><a href="https://depts.washington.edu/uwadv/toolkits/150th/">150th</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/advance/
">Advance</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/camp/">Campaign Preparedness</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/cfr/">CFR</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/comm/">Communications</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/compsuppt/">Computer Support, Centeal Units</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/convio/">Convio</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/dirmail/">Direct Mail</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/endow/">Endowment</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/events/">Events</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/found/">Foundation</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/frontline/">Frontline Fundraisers</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/gproc/">Gift Processing</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/planned/">Planned Giving</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/pmats/">PMATS</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/prosres/">Prospect Research</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/staffres/">Staff Resources</a></li>
              <li><a href="https://depts.washington.edu/uwadv/toolkits/pres/">Working with the President</a></li>
            </ul>

            <div class="mainNavBlurb">
              <p><span><a href=
              "http://www.washington.edu/discover/educationalexcellence"><img src=
              "http://www.washington.edu/images-library/band_stadium.jpg" alt=
              "UW Marching Band" class="image-inline" height="133" width=
              "200" /></a><br />
              Exceptional learning opportunities are around every corner. Our students
              have gone to the moon. Mapped the human genome. Broken the sound barrier.
              Created vaccines. Negotiated peace. What amazing things will UW grads do
              next? <a class="internal-link" href=
              "http://www.washington.edu/discover/educationalexcellence">Read
              more</a></span></p>
            </div><br class="clear" />
            <br class="clear" />
          </div>
        </div>
      </div>
    </li>

    <li class="mainNavLinkLeft">
      <div class="mainNavLinkRight">
        <h4><a class="mainNavLinkNotch" href="https://depts.washington.edu/uwadv/virtual-roundtables/">Virtual Roundtables</a></h4><br class="clear" />

        <div class="text">
          <div class="mainNavBG">
            <ul class="mainNavLinks">
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/advusers/">Advance Users</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/coord-asst/">Advancement Coords. & Assts.</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/cfd/">CFD</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/cro/">Constituent Relations Officers</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/convio-admins/">Convio Administrators</a></li>        
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/event-mgrs/">Event Managers</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/fundraisers/">Frontline Fundraisers</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/hiring-mgrs/">Hiring Managers</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/updaters/">Intranet Site Updaters</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/new/">New Staff</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/profdev/">Professional Development</a></li>
              <li><a href="https://depts.washington.edu/uwadv/virtual-roundtables/soc-med/">Social Media</a></li>
            </ul>

            <div class="mainNavBlurb">
              <p><span><a href=
              "http://www.washington.edu/discover/visionvalues"><img src="http://www.washington.edu/images-library/copy_of_nav_faculty.jpg"
              alt="Faculty/Staff" class="image-inline" /></a> The University of
              Washington recruits the best, most diverse and innovative faculty and staff
              from around the world, encouraging a vibrant intellectual community for our
              students. We promote access to excellence and strive to inspire through
              education. <a class="internal-link" href=
              "http://www.washington.edu/discover/visionvalues">Vision &amp;
              Values</a></span></p>
            </div><br class="clear" />
            <br class="clear" />
          </div>
        </div>
      </div>
    </li>
   
  </ul>        	       
  </div>

