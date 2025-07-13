DIST=dist
VERSIONS=$(shell find src -mindepth 1 -maxdepth 1 -type d | sed 's|src/||' | sort -V)
TARGETS=$(foreach v,${VERSIONS},${DIST}/BayisHungarianTranslations-${v}.zip)

all: ${TARGETS}
	@echo " * All Done."

clean:
	@echo " * Cleaning: ${DIST}"
	@rm -rf ${DIST} || true

%.zip:
	$(eval VERSION := $(shell echo $@ | sed 's|.*-\([0-9.]*\)\.zip|\1|'))
	@echo " * Building $@ for version ${VERSION}"
	@mkdir -p ${DIST} || true
	@mkdir -p temp/assets/ || true
	@cp src/${VERSION}/meta/* temp/
	@cp -Lr src/${VERSION}/active/* temp/assets/ || true
	@cd temp && zip -q -r ../$@ ./*
	@rm -rf temp || true

.PHONY: all clean
