while True:
    if currentTimer and not paused:
        time = timedelta(hours=int(currentTimer.get('hours', 0)),
                         minutes=int(currentTimer.get('minutes', 0)),
                         seconds=int(currentTimer.get('seconds', 0)))
        if currentTimer['done']:
            time += timedelta(seconds=1)
        else:
            time -= timedelta(seconds=1)
        if time.seconds == 0:
            currentTimer['done'] = True
        elif time.seconds <= 300:
            currentTimer['warning'] = True
        hours, remainder = divmod(time.seconds, 3600)
        minutes, seconds = divmod(remainder, 60)
        currentTimer['hours'] = hours
        currentTimer['minutes'] = minutes
        currentTimer['seconds'] = seconds
        if currentTimer['done'] and currentTimer['next']:
            query = {"category": currentTimer['category']}
            objects = db.timers.find(query)
            for obj in objects:
                if obj["_id"] == currentTimer['_id']:
                    try:
                        currentTimer = objects.next()
                        currentTimer['done'] = False
                    except Exception:
                        paused = True
                    finally:
                        break
    currentTimer['paused'] = paused
    currentTimer['hidden'] = hidden
    currentTimer['seconds'] = currentTimer.get('seconds', 0)
    currentTimer['minutes'] = currentTimer.get('minutes', 0)
