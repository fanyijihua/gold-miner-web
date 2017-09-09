test:
	@echo \"Error: no test specified\"

deploy:
	@git config user.username 'travis'
	@git config user.email 'travis@fanyi.juejin.im'
	@git fetch --unshallow
	@git remote add fanyi git@fanyi.juejin.im:gold-miner-web
	@git pull fanyi develop
	@git push fanyi develop

build:
	@cd FrontEnd && yarn && yarn run build

.PHONY: test deploy build
