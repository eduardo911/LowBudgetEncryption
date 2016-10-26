# LowBudgetEncryption
My own Encryption open source for all users
Commenting is not my strongest subject.
So far the encryption is base on a pattern that changes depending on specific variables.
I ask for feedback to improve the code and also credit since this is my first publish script I'll be working to update the code and make it look neat and programmer friendly.
Also i welcome you to reverse Engineer the code, please allow me with your method and feedback to fix my code.
any question feel free to contact me.

Update LowBudgetEncryption 1.2:
Problem:
issue was when it came to password with lengths of 3 and lower, there was a small pattern notice. no security issue for one brain but could potentially become a issue in the future.
Fix:
I check for the length of the range of the password and created a function to use basic  math to multiple the length of the range 2x making not only small passwords more complex but the large ones as well.
