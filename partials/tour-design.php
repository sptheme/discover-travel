<?php
/**
 * Template part for displaying tour design form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>
<?php $country_list = array("Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
	);?>

<div id="tour-design-form">
	<div id="result">&nbsp;</div>	
	<form class="send-tour-design" action="" method="post">
		
		<!-- Your destination -->
		<h3><?php echo get_post_meta( $post->ID, 'wpsp_step_title_1', true ); ?></h3>
		<section class="row custom-checkbox">
			<?php $destinations = get_post_meta( $post->ID, 'step_destinations', true ); ?>
			<?php foreach ($destinations as $destination) : ?>
			<div class="col-xs-6 col-md-3">
			<label for="<?php echo strtolower( str_replace( ' ', '-', $destination['title']) ); ?>">
				<figure>
					<img src="<?php echo $destination['thumbnail']; ?>">
					<i class="fa fa-check-circle-o"></i>
				</figure>
				<input type="checkbox" id="<?php echo strtolower( str_replace( ' ', '-', $destination['title']) ); ?>" value="<?php echo $destination['title']; ?>" name="destinations[]" class="checkbox-item required">
				<div><i class="fa fa-check-square"></i><?php echo $destination['title']; ?></div>
			</label>	
			</div> <!-- .col-md-3 -->
			<?php endforeach; ?>
			<div class="col-xs-6 col-md-3"><textarea rows="5" id="other-destination" name="otherdestination" placeholder="Other destination..."></textarea></div>
		</section>

		<!-- Your mood -->
		<h3><?php echo get_post_meta( $post->ID, 'wpsp_step_title_2', true ); ?></h3>
		<section class="row custom-checkbox">
			<?php $tour_styles = get_post_meta( $post->ID, 'step_mood', true ); ?>
			<?php foreach ($tour_styles as $style) : ?>
			<div class="col-xs-6 col-md-3">
			<label for="<?php echo strtolower( str_replace( ' ', '-', $style['title']) ); ?>">
				<figure>
					<img src="<?php echo $style['thumbnail']; ?>">
					<i class="fa fa-check-circle-o"></i>
				</figure>
				<input type="checkbox" id="<?php echo strtolower( str_replace( ' ', '-', $style['title']) ); ?>" value="<?php echo $style['title']; ?>" name="tourstyles[]" class="checkbox-item required">
				<div><i class="fa fa-check-square"></i><?php echo $style['title']; ?></div>
			</label>	
			</div> <!-- .col-md-3 -->
			<?php endforeach; ?>
		</section>

		<!-- Your detail -->
		<h3><?php echo get_post_meta( $post->ID, 'wpsp_step_title_3', true ); ?></h3>
		<section class="row">
			<div class="col-md-6">
				
				<input type="text" id="fullname" name="fullname" maxlength="40" placeholder="Your full name" class="required" />
				<input type="email" id="email" name="email" maxlength="40" placeholder="Your Email" class="required" />
				<input type="text" id="phone" name="phone" maxlength="14" placeholder="Your Phone" class="required" />
				<select id="country" name="country" class="required" />
					<option value="" selected="selected">Select coutnry</option>
					<?php foreach ( $country_list as $country ) : ?>
					<option value="<?php echo $country; ?>"><?php echo $country; ?></option>
					<?php endforeach ?>
				</select>

				<fieldset class="clearfix">
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

			</div> <!-- .col-md-6 -->
			<div class="col-md-6">
				<select id="tourclass" name="tourclass" class="required">
					<option value="<?php echo __('Economy 3 Star Hotel', 'discovertravel'); ?>"><?php echo __('Economy 3 Star Hotel', 'discovertravel'); ?></option> 
					<option value="<?php echo __('Deluxe 4 Star Hotel', 'discovertravel'); ?>"><?php echo __('Deluxe 4 Star Hotel', 'discovertravel'); ?></option> 
					<option value="<?php echo __('Luxury 5 Star Hotel', 'discovertravel'); ?>"><?php echo __('Luxury 5 Star Hotel', 'discovertravel'); ?></option> 
				</select>
				<input type="text" id="start-date" class="start-date required" name="departuredate" placeholder="Select date">
				<input type="text" id="trip-lenght" name="triplenght" maxlength="40" placeholder="Enter # Your Trip Lenght" class="required" />
				<textarea rows="8" id="other-request" name="otherrequest" placeholder="Any note or special request..."></textarea>
			</div> <!-- .col-md-6 -->
		</section> <!-- .row -->
	</form>
</div> <!-- #tour-design-form -->