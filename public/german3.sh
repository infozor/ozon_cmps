#!/bin/sh
### BEGIN INIT INFO
# Provides:          IonParsemarkServer
# Required-Start:    $network $remote_fs $syslog
# Required-Stop:     $network $remote_fs $syslog
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: starts IonParsemarkServer
# Description:       starts IonParsemarkServer using start-stop-daemon
### END INIT INFO

PATH=/sbin:/usr/sbin:/bin:/usr/bin
DAEMON=/usr/bin/php
DAEMON_OPTS="/var/www/ozonparsemark/public/socket_server.php start"
NAME=IonParsemarkServer
PIDFILE="/var/run/${NAME}.pid"
LOGFILE="/var/log/${NAME}.log"

test -x "$DAEMON" || exit 0

case "$1" in
  start)
    echo "Starting $NAME..."
    start-stop-daemon --start --background --make-pidfile --pidfile "$PIDFILE" --exec "$DAEMON" -- $DAEMON_OPTS >> "$LOGFILE" 2>&1 || true
    ;;
  stop)
    echo "Stopping $NAME..."
    start-stop-daemon --stop --pidfile "$PIDFILE" || true
    rm -f "$PIDFILE"
    ;;
  restart|force-reload)
    $0 stop
    sleep 1
    $0 start
    ;;
  *)
    echo "Usage: $0 {start|stop|restart|force-reload}"
    exit 1
    ;;
esac

exit 0
