#-------------------------------------------------------------------------------
#--- Create database and add user ----------------------------------------------
#-------------------------------------------------------------------------------
CREATE DATABASE comweb_project;
USE comweb_project;
CREATE USER 'comweb_project'@'localhost' IDENTIFIED BY 'tcejorp_bewmoc_isen29';
grant ALL PRIVILEGES ON comweb_project.* TO 'comweb_project'@'localhost';
FLUSH PRIVILEGES;
