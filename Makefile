.PHONY: dist clean score

ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

dist: dist/elasticpress_type_boost.zip

dist/elasticpress_type_boost.zip: *.php
	@mkdir -p dist
	@cd $(ROOT_DIR) && zip -9 $(ROOT_DIR)/dist/elasticpress_type_boost.zip *.php

clean:
	@rm -rf dist

score: dist/score.js

dist/score.js:
	@mkdir -p dist
	@cat score.js | tr -d '\n' | sed 's/  */ /g' | tee dist/score.js