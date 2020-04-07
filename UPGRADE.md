# Upgrading

## From 1.x to 2.x
Upgrade time: 1hour

This release changed everything, for good. No more inconsistencies, following SOLID principles, and well tested. 

But the breaking change list, is infinite.

*   **Removed functions** it was not compatible with the new way of managing things.

    But, see [Functional use](README.MD#functional-use), if you still want to use in a functional approach.

* **Library must be used with 7.3+**

* **Flashed does not have a ::getInstance method anymore**

* **Flasher is now Flash** and the old Flash class as been removed.

* **Flash->message() (formerly Flasher) is now Flash->flash()**

* **Storer CRAP is gone.**, now we got drivers.

* **Flash->pushTemplate() (formerly Flasher) is now Flash->setTemplate**

* **Flash->display() (formerly Flasher) is now Flash->render**

* **Flash constructor** you need to add a DriverInterface, TemplateInterface
   
   If you want PHP session based flashes, take [SessionDriver](src/Drivers/SessionDriver.php).

* **Templates must implement `toHtml` method instead of `wrap` method.**

* **DefaultTemplates is deleted**, it was the same as BootstrapTemplate, it was inconsistent.

* **The Utils class is deleted**, but it was supposed to be internal.

* **Arguments order is now $type, $message everywhre**, it was sometimes $message, $type, and $type, $message internally.
