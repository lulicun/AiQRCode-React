# iQRCode

Developer GetStarted

1. Install Virtualbox
https://www.virtualbox.org/wiki/Downloads

2. Install Vagrant
http://www.vagrantup.com/downloads.html

3. Fire application
cd root/of/application where the Vagrantfile saved
vagrant up
vagrant provision
vagrant ssh((You will see the IP address: IP address for eth1, type in your browser))



Front-Een Development
In order to user ReactJS + Flux, make sure you have nodeJS installed in your local, not vm.

1. Under puhblic/js/ folder, run
    sudo npm install

2. Install wachify to compile jsx to js
    sudo npm install watchify -g

3. Run
    watchify -0 target-bundle.js -v -d source.js
    ex:
        watchify -o bundles/ai-test-flux-todo-bundle.js -v -d src/test/flux-todo/app.js
