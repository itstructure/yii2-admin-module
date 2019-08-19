### CHANGE LOG:

**1.7.1 August 19, 2019:**
- Upgrade of the copyright time and add a personal site link.

**1.7.0 July 15, 2019:**
- Move scenarios constants to ```ModelInterface```. Set scenarios for main model in ```CommonAdminController``` (update, create).

**1.6.4 May 2, 2019:**
- Set **protected** type for function ```findModel($key)``` in ```CommonAdminController```.

**1.6.3 April 21, 2019:**
- in ```LanguageController``` bug fix for **actionSetDefault()** method: ```$language->default = $language->default == 0 ? 1 : 0```.
- Fixes for Readme file.

**1.6.2 February 24, 2019:**
- in ```MultilanguageValidateModel``` class the **mainModelAttributes()** method checking is added to check its presence in main model.

**1.6.1 August 5, 2018:**
- Code fixes according with the PSR standards.
- Add setter and getter for **mainModel** in ```MultilanguageValidateModel```.

**1.6.0 August 1, 2018:**
- Add ```urlPrefixNeighbor``` parameter in to ```AdminController``` for view links of neighbor entity.

**1.5.1 June 16, 2018:**
- Move ```urlPrefix``` parameter from ```CommonAdminController``` to ```AdminController``` for redirect and view links.

**1.5.0 June 16, 2018:**
- Add ```urlPrefix``` parameter in to ```CommonAdminController``` for redirect and view links.

**1.4.0 May 12, 2018:**
- Fixes bugs for attributes declaration in: CommonAdminController, ModelInterface, Language model, view template of language entity.
- Fixes for detect language and field name in MultilanguageTrait.
- Modify dependencies: minimum-stability is set to dev.
- Added prefer-stable with true.
- Add .scrutinizer file.
- Add badges:
    - Latest Stable Version
    - Latest Unstable Version
    - License
    - Total Downloads.
    - Build Status
    - Scrutinizer Code Quality

**1.3.1 May 5, 2018:**
- Change display register date in admin-menu with using date() function. In order not to depend on the need to install an intl extension.
- Setting a minimum php version restriction 7.1.

**1.3.0 April 23, 2018:**
- Change configuration parameters for MainMenuItem widget. Added attribute display. The meaning of the active attribute has been changed to a selection.
- Add getAdditionFields() function in CommonAdminController.
- Fix for returned value of __set() function in MultilanguageValidateModel.
- Modify dependencies in composer.json.
- Compact and modify comments.

**1.2.1 March 17, 2018:**
- Removing the Asset Link to jquery.min.js.
- Modify README decor.

**1.2.0 February 13, 2018:**
- Change var type from protected to private in CommonAdminController for: model, searchModel, 
validateComponent. They can be set and got just only by magic methods.

**1.1.0 February 13, 2018:**
- Add a static var "_translations" in module class. Automatic run registerTranslations() function,
 when the function **t()** in use.

**1.0.0 February 13, 2018:**
- Create module with the following options:
    - Use this module as base administrator dashboard to manage site content with the ability to extend it by children application CRUD's
    - Work in multilanguage mode for content
    - Work in multilanguage mode for dashboard
- Created documentation.
