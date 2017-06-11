#database for the Amba application
#If you change the name of the database, edit app/config/config.php

CREATE DATABASE IF NOT EXISTS amba1;

USE amba1;

#contains sender records. system currently assumes ONE sender
#but system may be extended, hence autoincrement
CREATE TABLE IF NOT EXISTS amb_sender(
    senderID INT(11) NOT NULL AUTO_INCREMENT,
    senderName VARCHAR(255) NOT NULL,
    senderAddress VARCHAR(255) NOT NULL,
    senderPassword VARCHAR(255) NOT NULL,
    salt VARCHAR(12) NOT NULL,
    
    PRIMARY KEY(senderID),
    UNIQUE(senderAddress),
    UNIQUE(salt)
);

#recipient=list of comma-separated receiving addresses
CREATE TABLE IF NOT EXISTS amb_outgoing(
    messageID INT(30) NOT NULL AUTO_INCREMENT,
    recipient VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT,
    sendDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY(messageID)
);

#table for future attachment support
CREATE TABLE IF NOT EXISTS amb_attachment(
    attachmentID INT(30) NOT NULL AUTO_INCREMENT,
    messageID INT(30) NOT NULL,
    fileURL VARCHAR(255) NOT NULL,
    
    PRIMARY KEY(attachmentID),
    FOREIGN KEY(messageID) REFERENCES amb_outgoing(messageID) ON DELETE CASCADE
);