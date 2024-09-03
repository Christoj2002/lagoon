ARG CLI_IMAGE
ARG LAGOON_IMAGE_VERSION
FROM ${CLI_IMAGE} as cli

FROM uselagoon/php-8.1-fpm:${LAGOON_IMAGE_VERSION}

ARG SIMPLESAMLPHP_CONFIG_DIR

ENV SIMPLESAMLPHP_CONFIG_DIR=${SIMPLESAMLPHP_CONFIG_DIR}

COPY .docker/images/php/01-govcms.ini /usr/local/etc/php/conf.d/
COPY --from=cli /app /app
COPY .docker/sanitize.sh /app/sanitize.sh

RUN /app/sanitize.sh \
  && rm -rf /app/sanitize.sh
