<?php
/**
 * Template part for displaying tour inquiry form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php $country_list = array("Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
	);?>

<div id="tour-inquiry-form" class="white-popup-block mfp-with-anim mfp-hide">
	<div id="result">&nbsp;</div>
	<form class="send-tour-inquiry" action="" method="post">
	<h2 class="popup-title">Tour Inquiry</h2>
	<fieldset class="clearfix">
		<legend>You Will Travel</legend>
		<div id="type-solo" class="people">
			<label for="solo-tour">
				<i class="solo-icon"></i>
				<input type="radio" id="solo-tour" value="solo" name="tourtype" class="default-radio" checked="checked">
				<span class="radio-image">Solo</span>
			</label>
		</div>
		<div id="type-couple" class="people">
			<label for="couple-tour">
				<i class="couple-icon"></i>
				<input type="radio" id="couple-tour" value="couple" name="tourtype" class="default-radio">
				<span class="radio-image">Couple</span>
			</label>
		</div>
		<div id="type-family" class="people">
			<label for="family-tour">
				<i class="family-icon"></i>
				<input type="radio" id="family-tour" value="family" name="tourtype" class="default-radio">
				<span class="radio-image">Family</span>
			</label>
		</div>
		<div id="type-group" class="people">
			<label for="group-tour">
				<i class="group-icon"></i>
				<input type="radio" id="group-tour" value="group" name="tourtype" class="default-radio">		
				<span class="radio-image">Group</span>
			</label>
		</div>
		<div class="people-addon clearfix">
			<div id="adult" class="adult-number">
				<select name="adult" class="number">
					<option value="1">1</option>
					<option value="2" selected="selected">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				<p>Adults (>12)</p>
			</div> <!-- .number -->
			<div id="children" class="children-number">
				<select name="children" class="number">
					<option value="0" selected="selected">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<p>Children (2-10)</p>
			</div> <!-- .children -->
			<div id="kids" class="kids-number">
				<select name="kids" class="number">
					<option value="0" selected="selected">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<p>Babies (0-2)</p>
			</div> <!-- .kids -->
		</div><!-- .people-addon -->
	</fieldset> 
	<fieldset class="clearfix">
		<legend>Tour Class</legend>
		<div id="eco-class" class="tour-class">
			<label for="economy">
				<i class="economy-icon"></i>
				<input type="radio" id="economy" value="3 Star economy" name="tourclass" class="default-radio" checked="checked">
				<span class="radio-image">3 Star Economy</span>
			</label>
		</div>
		<div id="deluxe-class" class="tour-class">
			<label for="deluxe">
				<i class="deluxe-icon"></i>
				<input type="radio" id="deluxe" value="4 Star Deluxe" name="tourclass" class="default-radio">
				<span class="radio-image">4 Star Deluxe</span>
			</label>
		</div>
		<div id="luxury-class" class="tour-class">
			<label for="luxury">
				<i class="luxury-icon"></i>
				<input type="radio" id="luxury" value="5 Star Luxury" name="tourclass" class="default-radio">
				<span class="radio-image">5 Star Luxury</span>
			</label>
		</div>
	</fieldset>	
	<fieldset class="clearfix">
		<legend>Departure Date</legend>
		<input type="text" id="departure-date" class="departure-date" name="departuredate" placeholder="Select date">
		<div id="is-flexible-date" class="flexible-date">
			<label for="flexible-date">
				<input type="checkbox" id="flexible-date" value="1" name="flexibledate">
				My date is flexible
			</label>
			<input type="text" id="manual-date" name="manualdate" class="manual-date" placeholder="Type your flexible date">
		</div>
	</fieldset>	
	<fieldset id="personal-info" class="row">
		<legend>Personal Detail</legend>
		<div class="col-sm-2">
		<select id="title" name="title">
			<option value="Mr.">Mr.</option> 
			<option value="Mrs.">Mrs.</option> 
			<option value="Ms.">Ms.</option> 
			<option value="Miss.">Miss.</option> 
			<option value="Dr.">Dr.</option>
		</select>
		</div>
		<div class="col-sm-5"><input type="text" id="first-name" name="firstname" maxlength="40" placeholder="First Name" /></div>
		<div class="col-sm-5"><input type="text" id="last-name" name="lastname" maxlength="40" placeholder="Last Name" /></div>
		<div class="col-sm-12 col-md-4"><input type="email" id="email" name="email" maxlength="40" placeholder="Your Email" /></div>
		<div class="col-sm-12 col-md-4"><input type="text" id="phone" name="phone" maxlength="14" placeholder="Your Phone" /></div>
		<div class="col-sm-12 col-md-4">
			<select id="country" name="country" />
				<option value="" selected="selected">Select coutnry</option>
				<?php foreach ( $country_list as $country ) : ?>
				<option value="<?php echo $country; ?>"><?php echo $country; ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="col-sm-12"><textarea rows="5" id="other-request" name="otherrequest" placeholder="Any note or special request..."></textarea></div>
	</fieldset>
	<p><input type="submit" value="<?php echo __('Send my request', 'discovertravel'); ?>" /></p>
	<input type="hidden" name="tourname" value="<?php the_title(); ?>">
	<input type="hidden" name="tourday" value="<?php echo get_post_meta( get_the_ID(), 'wpsp_day_amount', true ); ?>">
	</form>
</div>