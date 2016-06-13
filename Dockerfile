FROM flucerjustbate/justbate:latest
MAINTAINER admin@max-metal.us
RUN apt-get update -y && apt-get upgrade -y
RUN apt-get install git -y
RUN apt-get autoclean && apt-get autoremove 
RUN git clone git@github.com:robert589/justbate.git
