Vagrant.configure(2) do |config|

  config.vm.box = "centos7_minimal.box"

  config.vm.network "forwarded_port", guest: 80, host: 4443

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.network "public_network"
  
  config.vm.provision "shell", path: "config_file/script.sh"
  
  config.vm.provision "puppet"

end
