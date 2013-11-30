
        RAMP/SMART Customization Instructions for the
                    application.ini file
        ---------------------------------------------

This file contains 

for Ramp
(Record and Activity Management Program) and Smart (Software for Managing
Academic Records and Transcripts).

1. Getting Ready:
-----------------

You should already have a list of databases you plan to set up (see
INSTALL_DB.txt).  

2. Addressing Security Concerns:
--------------------------------

    * Ramp's application/configs/application.ini file should be
      protected, but must be readable by the web server.  The best
      way to achieve this could be, for example, to have the
      application.ini owned by the database administrator but part
      of the same group as the httpd web server (or vice versa).

Basics:
  -- Customize timezone if necessary (phpSettings.date.timezone).
  -- 

4. Granting MySQL Accounts Access to Databases:
-----------------------------------------------

    * Make a section in the application.ini file for each database you
      defined.  The rampApplicationTemplate.ini file contains examples.
      The main database is listed first, along with the properties it
      needs.  Other sections, representing other databases, follow it.
      (The sections do not have to have the exact same names as the
      databases, but their names should make it clear what the
      associations are.) To make the file easier to read and maintain,
      you should define your additional databases as inheriting
      from the main database and then, in each section, only define
      those properties that must be different for this database.
      For example, you might have a "smart" production database and
      a "smart_dev" development database, with sections such as the
      following in your application.ini file:
        [production]
        ; ... Many properties defined here, including
        resources.db.params.username = smartuser
        resources.db.params.password = "a_real_passwd"
        resources.db.params.dbname = smart
        [development: production]
        resources.db.params.dbname = smart_dev
        ; ... A few other redefined properties go here ...
      In this example, the section named "production" contains several
      properties, including the database name ("...dbname = smart")
      and the username and password that Ramp/Smart uses to access
      the database.  The "development" section specifies that it
      inherits properties from the "production" section ("[development:
      production]"), but it also redefines some properties such
      as the database name ("...dbname = smart_dev").  It does not
      redefine the username and password, establishing that the
      same username and password are use to access the development
      database as the production database.

5. Setting Up Databases, Ramp/Smart User Accounts, and Authorization:
---------------------------------------------------------------------

    * Define Roles:
      Update the application/configs/application.ini file to specify
      the non-guest roles you want to define for each database.
      (The rampApplicationTemplate.ini file is already setup to
      configure a simple ramp_demo database.  The
      smartApplicationTemplate.ini file provides more complex examples.)

Ramp Basics:
  -- Customize timezone if necessary (phpSettings.date.timezone).
  -- Define the authentication type and, if using internal
     authentication, the default password that indicates a user should
     be prompted to set an actual password that will be encrypted.
     (Note: internal authentication is the only authentication type
     that is currently supported.)

Customizing for the Application:
  -- Authorization:  See separate section on defining roles, resources,
     and authorization rules!

  -- Customize documentation root (optional: will use settings directory
     otherwise).  Customize settings directory (may need to override
     this in some environments -- see below).

  -- Menus (here or in next section?): ramp.menuFilename provides a
     single menu for all users (including ones who are not logged in).
     It's possible, though, to create different menus for different
     roles, e.g., ramp.roleBasedMenus['guest'] = ".../guestMenu.ini" and
     ramp.roleBasedMenus['ramp_dba'] = ".../dbaMenu.ini".  If there is
     no role-based menu for the user's role, then RAMP will use the
     menuFilename property.  [ TODO: a) Don't remember what RAMP does if
     menuFilename is undefined.  b) What if there is no role-based menu
     for user's role, but there is one for a role from which the user's
     role inherits? Too bad -- multiple inheritance makes that too
     complicated. ]

Customizing for various Environments/Databases:
  -- [Development environments only]: Allow system (PHP/Zend) errors
     to be displayed when running a development environment.
  -- Define settings for accessing the database for the environment:
     Under resources.db.params, set the username, password, and dbname
     appropriately.  I think it is unlikely you will need to change the
     host, since the activities and table settings are likely to be on
     the same host as the database.  At this point, RAMP has only be
     tested with a PDO_MYSQL database and might not work with any other.
  -- Define settings that control the look and feel.
     You can customize the title, subtitle, applicationShortName, and
     icon if you want.  To further customize the look and feel, you will
     need to edit the cascading style sheets (currently in
     /css/site.css).
  -- Define the Ramp menu, where to find activities and table settings,
     and the initial activity.  ...

Authorization: Roles:

; Define Access Control List roles.  The syntax is:
;   ramp.aclNonGuestRole.newRole = inheritFromExistingRole
; which defines a new role that inherits access rules from the
; existing role but can have new rules associated with it also.
;   NOTE 1: The 'guest' role is hard-coded in Ramp_Acl.  Other roles
should
;     inherit from 'guest' or from each other.
;   NOTE 2: An admin role should exist (e.g., ramp_dba or smart_dba);
you
;     may modify it to inherit from other roles if that is appropriate
for
;     the application.
;   NOTE 3: Can have multiple inheritance, as follows:
;     ramp.aclNonGuestRole.registrar[] = 'hrManagement'
;     ramp.aclNonGuestRole.registrar[] = 'registManagement'
;   Later parents take precedence over earlier ones if there are
conflicts.

NOTE: even though ini sections can inherit properties from other
sections, it seems that you can't inherit non-guest roles and add 
others.  I seem to have had to redefine all the roles when I want to
change any of them in a particular environment (section).  [Double-check
whether this is true, since inheritance seems to work great in table
settings.]

Authorization: Resources:
; Define basic Access Control List resources.  (These resources and
others
; may also be specified in the RAMP Authorizations table.)  Resource
; specifications fall into three general categories:
;    Controller actions:    controller::action
;    Activity directories:  activity::index::directory
;    Table/Report actions:  table::action::db_table_name  (not setting)
;

If you have activity files in the top-level table setting
directory (e.g., settings), use '.' for the directory, i.e.,
    activity::index::.


Authorization: Rules:
; Define basic Access Control List rules.  A rule should consist of a
role,
; followed by the "::" delimiter, followed by the resource, where
; resources are defined as described above.
;       "role::resource"
;
; The following rules give:
;    * the "guest" role (users not logged in) access to activities in
;      the PublicActivities directory
;    * users with the ramp_dba role:
;        -- access to the validate-roles and validate-acl-rules actions
;           in AuthController (This authorization can NOT be specified
;           in the ramp_auth_auths table!)
;        -- access to activities in the Admin directory.
;
; Note: the resources for the validate-roles and validate-acl-rules
; actions in AuthController (and the ramp_auth_users and ramp_auth_auths
; tables) are built in to RAMP software.
ramp.aclRules[] = "guest::activity::index::PublicActivities"
ramp.aclRules[] = "ramp_dba::activity::index::Admin"
ramp.aclRules[] = "ramp_dba::auth::reset-password"
ramp.aclRules[] = "ramp_dba::auth::validate-roles"
ramp.aclRules[] = "ramp_dba::auth::validate-acl-rules"
; This list could be expanded to give the ramp_dba role authorization to
; update the pre-defined Users table (ramp_auth_users) and
Authorizations
; table (ramp_auth_auths) if that was not done when the tables were
; created. For example, 
; ramp.aclRules[] = "ramp_dba::table::index::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::search::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::list-view::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::table-view::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::record-view::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::add::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::record-edit::ramp_auth_auths"
; ramp.aclRules[] = "ramp_dba::table::delete::ramp_auth_auths"

If you want to allow activity files in the top-level table setting
directory (e.g., settings), use '.' for the directory, i.e.,
    guest::activity::index::.

