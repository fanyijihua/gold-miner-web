test:
	@echo \"Error: no test specified\"

deploy:
	@git config user.username 'travis'
	@git config user.email 'travis@fanyi.juejin.im'
	@git remote add fanyi git@fanyi.juejin.im:gold-miner-web
	@git push fanyi develop

.PHONY: test deploy
