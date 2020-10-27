#include "dateclass.h"
#include <QDebug>
#include <QDate>

DateClass::DateClass()
{

}

QString DateClass::getDate() {
 QDate date = QDate::currentDate();
 return date.toString("dd.MM.yyyy");
}

QString DateClass::next_day(QString date) {
 QDate tmp = QDate::fromString(date,"dd.MM.yyyy");
 QDate new_date = tmp.addDays(1);
 return new_date.toString("dd.MM.yyyy");
}

QString DateClass::prev_day(QString date) {
    QDate tmp = QDate::fromString(date,"dd.MM.yyyy");
    QDate new_date = tmp.addDays(-1);
    return new_date.toString("dd.MM.yyyy");
}

QString DateClass::current_time() {
    QTime t = QTime::currentTime();
    return t.toString("hh:mm:ss.zzz");
}
