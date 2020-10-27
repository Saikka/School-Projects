#ifndef DATABASE_H
#define DATABASE_H

#include <QObject>
#include <QSql>
#include <QSqlQuery>
#include <QSqlError>
#include <QSqlDatabase>
#include <QFile>
#include <QDate>
#include <QDebug>

#define DATABASE_HOSTNAME   "TasksDataBase"
#define DATABASE_NAME       "TasksTable.db"

#define TABLE                  "TaskTable"
#define TABLE_DATE             "Date"
#define TABLE_NAME             "Name"
#define TABLE_CITY             "City"
#define TABLE_ADDRESS          "Address"
#define TABLE_TIME             "Time"
#define TABLE_COLOR            "Color"
#define TABLE_NOTES            "Notes"


class DataBase : public QObject
{
    Q_OBJECT
public:
    explicit DataBase(QObject *parent = 0);
    ~DataBase();
    void connectToDataBase();

private:
    QSqlDatabase    db;

private:
    bool openDataBase();
    bool restoreDataBase();
    void closeDataBase();
    bool createTable();

public slots:
    bool inserIntoTable(const QVariantList &data);
    bool inserIntoTable(const QString &date, const QString &name, const QString &city, const QString &address, const QString &time, const QString &color, const QString &notes);
    bool removeRecord(const int id);
    bool updateRecord(const int id, const QString &name, const QString &city, const QString &address, const QString &time, const QString &color, const QString &notes);
};

#endif // DATABASE_H
