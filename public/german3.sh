#! /bin/sh

### BEGIN INIT INFO
# Provides:          IonParcemarkServer
# Required-Start:    $all
# Required-Stop:     $all
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: starts IonParsemarkServer
# Description:       starts IonParsemarkServer using start-stop-daemon
### END INIT INFO

# Load the VERBOSE setting and other rcS variables
. /lib/init/vars.sh

DAEMON=/usr/bin/php
DAEMON_OPTS='/var/www/ozonparsemark/public/socket_server.php start'

NAME=IonParsemarkServer
DESC=IonParsemarkServer
PIDFILE="/var/run/${NAME}.pid"
LOGFILE="/var/log/${NAME}.log"
START_OPTS="--start --background --make-pidfile --pidfile ${PIDFILE} --exec ${DAEMON} ${DAEMON_OPTS}"
STOP_OPTS="--stop --pidfile ${PIDFILE}"

test -x $DAEMON || exit 0

set -e

case "$1" in
  start)
	echo -n "Starting $DESC: "
	start-stop-daemon $START_OPTS >> $LOGFILE
	echo "$NAME."
	;;
  stop)
	echo -n "Stopping $DESC: "
	start-stop-daemon $STOP_OPTS
	rm -f $PIDFILE
	echo "$NAME."
	;;
  restart|force-reload)
	echo -n "Restarting $DESC: "
	start-stop-daemon $STOP_OPTS
	sleep 1
	start-stop-daemon $START_OPTS
	echo "$NAME."
	;;
  *)
	N=/etc/init.d/$NAME
	echo "Usage: $N {start|stop|restart|force-reload}" >&2
	exit 1
	;;
esac

exit 0