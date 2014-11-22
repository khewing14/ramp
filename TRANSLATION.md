# Translation Guide #

## Adding translations ##

#### Translations in PHP ####

Translating text which occurs in PHP code requires the use of the Zend_Translate object.
The Zend_Translate object uses a key-value pairing to translate text. Keys represent the
"text to be translated", and the values differ depending on which language the code is to
be translated into. The Zend_Translate object is used in conjunction with an Adapter, which
can take translation data and convert it into something the Zend_Translate object can work
with. RAMP currently uses an Array Adapter, due to its simplicitiy of implementation.
However, a large scale production environment using RAMP will likely want to implement a
more scalable adapter.

In depth documentation available here: http://framework.zend.com/manual/1.12/en/zend.translate.html

#### Translations in Table Settings ####

As you know, ramp requires an "environment" to be run in, which includes a list of settings and
activity files. These files should be in a directory structure such as /settings/<<locale>>/files.
The locale represents the current language the software is designed to run in. Therefore, when
translating RAMP into a new language, you must add table settings files in the new language. This
can be done by copying all table settings from a given language to the new locale folder. For example,
if we wanted to translate RAMP into spanish, we could do the following.

```
mkdir <<your_ramp_environment>>/settings/es
cp -R <<your_ramp_environment>>/settings/en/ <<your_ramp_environment>>/settings/es
git add .
git cm -m "Add spanish translation table settings files"
```

After doing this, you can translate text items individually in the settings/es directory
to spanish. Once this is done, commit your changes and push to your remote repository to
ensure you don't lose any of your changes.

## Changing languages ##

Changing languages of RAMP requires no code changes, however the steps can be different
depending on the machine and browser you are running on.  Step one involves ensuring your
computers language setting is the same as what you want RAMP to be translated into. For
example, if you want RAMP to be translated into spanish, you should have your operating
system set up in spanish. This is generally easy to change, and is documented separately
for each operating system. If you are having trouble, a quick google search will lead
you to the answer. Browsers will generally read the locale from your computer. However,
sometimes changing languages requires that you additionally reconfigure your browser to
use the desired locale. This process will be slightly different depending on which browser
is in use, however it is easy to change in the browser settings. If you are having difficulty,
please consult your browsers documentation. Once your computer is fully set up in a given
language, RAMP will read the language from the OS/Browser setup, and figure out what language
to render your application in.