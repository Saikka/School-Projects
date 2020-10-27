#ifndef DATECLASS_H
#define DATECLASS_H

#include <QObject>

class DateClass : public QObject
{
    Q_OBJECT
public:
    DateClass();

public slots:
    QString getDate();
    QString next_day(QString date);
    QString prev_day(QString date);
    QString current_time();
};

#endif // TEST_H
