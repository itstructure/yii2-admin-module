### CHANGE LOG:

**1.2.0:**
- Change var type from protected to private in CommonAdminController for: model, searchModel, 
validateComponent. They can be set and got just only by magic methods.

**1.1.0:**
- Add a static var "_translations" in module class. Automatic run registerTranslations() function,
 when the function **t()** in use.

**1.0.0:**
- Create module with the following options:
    - Use this module as base administrator dashboard to manage site content with the ability to extend it by children application CRUD's
    - Work in multilanguage mode for content
    - Work in multilanguage mode for dashboard
- Created documentation.
