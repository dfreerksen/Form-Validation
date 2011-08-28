**PCI Compliant Password**

    $this->form_validation->set_rules('password', 'Password', 'pci_password|required');


Useful when:

* Paswords must be PCI compliant.


Requirements:

* Length between 6 and 99 characters

* Must not contain two consecutively repeating characters

* Must contain at least one upper-case letter

* Must contain at least one lower-case letter

* Must contain at least one number

* Must contain at least one special character (!@#$%*-_=+.)




**Unique**

    $this->form_validation->set_rules('email', 'Email', 'unique[MyTable,MyField]|required');

    $this->form_validation->set_rules('email', 'Email', 'unique[Users,email]|required');


Useful when:

* Creating a new user.


Where:

* MyTable is the name of the database table to look in

* MyField is the name of the field in the database table to look at




**Unique Except**

    $this->form_validation->set_rules('email', 'Email', 'unique_except[MyTable,MyField,MyIdField,MyId]|valid_email|required');

    $this->form_validation->set_rules('email', 'Email', 'unique_except[Users,email,user_id,24]|valid_email|required');


Useful when:

* Updating an existing users information.



Where:

* MyTable is the name of the database table to look in

* MyField is the name of the field in the database table to look at

* MyIdField is the name of the field in the database that is the unique ID field

* MyId is the associated unique ID of the MyField field




**Required If**

    $this->form_validation->set_rules('username', 'Username', 'required_if[OtherFormField]|required');

    $this->form_validation->set_rules('username', 'Username', 'required_if[OtherFormField,OtherFormFieldValue]|required');

    $this->form_validation->set_rules('username', 'Username', 'required_if[user_role]|required');

    $this->form_validation->set_rules('username', 'Username', 'required_if[user_role,admin]|required');



Useful when:

* Making fields required if another field is either filled in or filled in and has a specific value.



Where:

* OtherFormField is the name of the other form field

* OtherFormFieldValue (optional) is the value of the other form field