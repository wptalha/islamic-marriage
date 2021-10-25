CREATE TABLE `login` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;


CREATE TABLE `beneficiary` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `accnum` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `login_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  CONSTRAINT FK_beneficiary_1
  FOREIGN KEY (login_id) REFERENCES login(id)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE `transfer` (
  `id` int(11) NOT NULL auto_increment,
   `accnum` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
   `currency` varchar(100) NOT NULL,
   `ref` varchar(100) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `login_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  CONSTRAINT FK_transfer_1
  FOREIGN KEY (login_id) REFERENCES login(id)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;