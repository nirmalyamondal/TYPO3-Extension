#
# Table structure for table 'tx_typo3scorm_domain_model_scormcourse'
#
CREATE TABLE tx_typo3scorm_domain_model_scormcourse (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	cloud_id varchar(255) DEFAULT '' NOT NULL,
	course_name varchar(255) DEFAULT '' NOT NULL,
	creation_time int(11) DEFAULT '0' NOT NULL,
	update_time int(11) DEFAULT '0' NOT NULL,
	score_format varchar(255) DEFAULT '' NOT NULL,
	allow_preview tinyint(1) unsigned DEFAULT '0' NOT NULL,
	allow_review tinyint(1) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

#
# Table structure for table 'tx_typo3scorm_domain_model_scormuser'
#
CREATE TABLE tx_typo3scorm_domain_model_scormuser (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	t3user_id int(11) DEFAULT '0' NOT NULL,
	reg_id varchar(255) DEFAULT '' NOT NULL,
	scorm_cloud varchar(255) DEFAULT '' NOT NULL,
	scorm_local int(11) DEFAULT '0' NOT NULL,
	completion varchar(255) DEFAULT '' NOT NULL,
	satisfaction varchar(255) DEFAULT '' NOT NULL,
	score varchar(255) DEFAULT '' NOT NULL,
	total_time varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);