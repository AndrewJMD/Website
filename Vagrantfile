Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.provision :shell, path: "vm_provision/provision.sh"
  config.vm.provision :shell, path: "vm_provision/up.sh", run: "always"
  config.vm.network "private_network", ip: "10.0.0.10"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--cpuexecutioncap", "50", "--cpus", "2"]
    vb.memory = 1024
  end
end
