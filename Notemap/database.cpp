#include "database.h"

DataBase::DataBase(QObject *parent) : QObject(parent)
{

}

DataBase::~DataBase()
{

}

void DataBase::connectToDataBase()
{
    if(!QFile(DATABASE_NAME).exists()){
        this->restoreDataBase();
    } else {
        this->openDataBase();
    }
}

bool DataBase::restoreDataBase()
{
    if(this->openDataBase()){
        return (this->createTable()) ? true : false;
    } else {
        qDebug() << "Failed to recover database";
        return false;
    }
    return false;
}

bool DataBase::openDataBase()
{
    db = QSqlDatabase::addDatabase("QSQLITE");
    db.setHostName(DATABASE_HOSTNAME);
    db.setDatabaseName(DATABASE_NAME);
    if(db.open()){
        return true;
    } else {
        return false;
    }
}

void DataBase::closeDataBase()
{
    db.close();
}

bool DataBase::createTable()
{
    QSqlQuery query;
    if(!query.exec( "CREATE TABLE " TABLE " ("
                            "id INTEGER PRIMARY KEY AUTOINCREMENT, "
                            TABLE_DATE     " VARCHAR(255)    NOT NULL,"
                            TABLE_NAME     " VARCHAR(255)    NOT NULL,"
                            TABLE_CITY     " VARCHAR(255)    NOT NULL,"
                            TABLE_ADDRESS     " VARCHAR(255)    NOT NULL,"
                            TABLE_TIME       " VARCHAR(255)    NOT NULL,"
                            TABLE_COLOR       " VARCHAR(255)    NOT NULL,"
                            TABLE_NOTES       " VARCHAR(255)    NOT NULL"
                        " )"
                    )){
        qDebug() << "DataBase: error of create " << TABLE;
        qDebug() << query.lastError().text();
        return false;
    } else {
        return true;
    }
    return false;
}

bool DataBase::inserIntoTable(const QVariantList &data)
{
    QSqlQuery query;
    query.prepare("INSERT INTO " TABLE " ( " TABLE_DATE ", "
                                             TABLE_NAME ", "
                                             TABLE_CITY ", "
                                             TABLE_ADDRESS ", "
                                             TABLE_TIME ", "
                                             TABLE_COLOR ", "
                                             TABLE_NOTES " ) "
                  "VALUES (:Date, :Name, :City, :Address, :Time, :Color, :Notes)");
    query.bindValue(":Date",       data[0].toString());
    query.bindValue(":Name",       data[1].toString());
    query.bindValue(":City",       data[2].toString());
    query.bindValue(":Address",       data[3].toString());
    query.bindValue(":Time",         data[4].toString());
    query.bindValue(":Color",       data[5].toString());
    query.bindValue(":Notes",         data[6].toString());

    if(!query.exec()){
        qDebug() << "error insert into " << TABLE;
        qDebug() << query.lastError().text();
        return false;
    } else {
        return true;
    }
    return false;
}

bool DataBase::inserIntoTable(const QString &date, const QString &name, const QString &city, const QString &address, const QString &time, const QString &color, const QString &notes)
{
    QVariantList data;
    data.append(date);
    data.append(name);
    data.append(city);
    data.append(address);
    data.append(time);
    data.append(color);
    data.append(notes);

    if(inserIntoTable(data))
        return true;
    else
        return false;
}

bool DataBase::removeRecord(const int id)
{
    QSqlQuery query;
    query.prepare("DELETE FROM " TABLE " WHERE id= :ID ;");
    query.bindValue(":ID", id);

    if(!query.exec()){
        qDebug() << "error delete row " << TABLE;
        qDebug() << query.lastError().text();
        return false;
    } else {
        return true;
    }
    return false;
}

bool DataBase::updateRecord(const int id, const QString &name, const QString &city, const QString &address, const QString &time, const QString &color, const QString &notes)
{
    QSqlQuery query;
    query.prepare("UPDATE " TABLE " SET " TABLE_NAME "=:Name, " TABLE_CITY "=:City, " TABLE_ADDRESS "=:Address, " TABLE_TIME "=:Time, " TABLE_COLOR "=:Color, " TABLE_NOTES "=:Notes WHERE id=:ID;");
    query.bindValue(":ID", id);
    query.bindValue(":Name", name);
    query.bindValue(":City", city);
    query.bindValue(":Address", address);
    query.bindValue(":Time", time);
    query.bindValue(":Color", color);
    query.bindValue(":Notes", notes);
    if(!query.exec()){
        qDebug() << "error update row " << TABLE;
        qDebug() << query.lastError().text();
        return false;
    } else {
        return true;
    }
    return false;
}

