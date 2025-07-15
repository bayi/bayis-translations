DIST=dist
NAME=BayisHungarianTranslations
VERSIONS=$(shell find src -mindepth 1 -maxdepth 1 -type d | sed 's|src/||' | sort -V)
CURRENT_VERSION=$(shell cat VERSION)
TARGETS=$(foreach v,${VERSIONS},${NAME}-${CURRENT_VERSION}-${v}.zip)

ifneq ("$(wildcard .env)","")
	include .env
	export $(shell sed 's/=.*//' .env)
endif

all: build
	@echo -e " \033[32m* All Done.\033[0m"

build: $(TARGETS)
	@echo -e " \033[32m* Built \033[0m${TARGETS}\033[32m in \033[0m${DIST}"

install: build
	@echo -e " \033[32m* Installing files in modpacks\033[0m"
	@php bin/install.php ${NAME} ${CURRENT_VERSION} ${DIST}

readme:
	@echo -e " \033[32m* Building\033[0m README.md"
	@rm -f README.md || true
	@php bin/generate-readme.php > README.md

update-upstream:
	@echo -e " \033[32m* Updating upstream translations\033[0m"
	@php bin/update-upstream.php

%.zip:
	$(eval VERSION := $(shell echo $@ | sed 's|.*-\([0-9.]*\)\.zip|\1|'))
	@echo -e " \033[32m* Building\033[0m $@ \033[32mfor version\033[0m ${VERSION}"
	@mkdir -p ${DIST} || true
	@mkdir -p temp/assets/ || true
	@cp src/${VERSION}/meta/* temp/
	@cp -Lr src/${VERSION}/active/* temp/assets/ || true
	@cd temp && zip -q -r ../${DIST}/$@ ./*
	@rm -rf temp || true

publish: readme build
	@echo -e " \033[32m* Publishing to Modrinth\033[0m"
	@php bin/publish.php 1.20.1
	@php bin/publish.php 1.21.1
	@php bin/update-project.php

clean:
	@echo -e " \033[31m* Cleaning:\033[0m ${DIST}"
	@rm -rf ${DIST} || true
	@rm -rf temp || true

.PHONY: all clean build install
