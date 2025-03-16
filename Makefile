DIST=BayisHungarianTranslations.zip

all:
	@rm ${DIST} || true
	@echo " * Creating ${DIST}"
	@cd src && zip -q -r ../${DIST} .
