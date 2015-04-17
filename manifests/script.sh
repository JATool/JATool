rpm -ivh http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.3-1.el7.rf.x86_64.rpm
rpm -ivh http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
rpm -ivh http://repo.webtatic.com/yum/el7/webtatic-release.rpm
rpm -ivh http://dl.atrpms.net/all/atrpms-repo-7-7.el7.x86_64.rpm
rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
rpm -ivh http://yum.puppetlabs.com/puppetlabs-release-el-7.noarch.rpm
yum -y install puppet
systemctl start puppet
systemctl enable puppet