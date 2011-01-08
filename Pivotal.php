<?php
# Copyright (C) 2010 Andre Wyrwa
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.


/**
 * Provides access to the jQuery library as a MantisBT plugin.
 */
class PivotalPlugin extends MantisPlugin {

	function register() {
		$this->name = 'Pivotal Tracker Integration';
		$this->description = 'Provides Integration for Pivotal\'s Other-Integration-API';

		$this->version = '1.0.0';
		$this->requires = array(
			'MantisCore' => '1.2.0',
		);

		$this->author	= 'Andre Wyrwa';
		$this->contact	= 'a.wyrwa@gmx.de';
		$this->url		= '';
	}

	function init() {

	}
}