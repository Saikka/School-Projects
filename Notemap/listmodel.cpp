#include "listmodel.h"
#include "database.h"
#include <QDate>

ListModel::ListModel(QObject *parent) :
    QSqlQueryModel(parent)
{
    QDate date = QDate::currentDate();
    this->updateModel(date.toString("dd.MM.yyyy"));
}

QVariant ListModel::data(const QModelIndex & index, int role) const {

    int columnId = role - Qt::UserRole - 1;
    QModelIndex modelIndex = this->index(index.row(), columnId);

    return QSqlQueryModel::data(modelIndex, Qt::DisplayRole);
}

QHash<int, QByteArray> ListModel::roleNames() const {
    QHash<int, QByteArray> roles;
    roles[IdRole] = "id";
    roles[DateRole] = "date";
    roles[NameRole] = "name";
    roles[CityRole] = "city";
    roles[AddressRole] = "address";
    roles[TimeRole] = "time";
    roles[ColorRole] = "color";
    roles[NotesRole] = "notes";
    return roles;
}

void ListModel::updateModel(QString d)
{
    QSqlQuery query;
    query.prepare("SELECT id, " TABLE_DATE ", " TABLE_NAME ", " TABLE_CITY ", " TABLE_ADDRESS ", " TABLE_TIME ", " TABLE_COLOR ", " TABLE_NOTES " FROM " TABLE " WHERE " TABLE_DATE " = :DATE;");
    query.bindValue(":DATE", d);
    query.exec();
    this->setQuery(query);
}

int ListModel::getId(int row)
{
    return this->data(this->index(row, 0), IdRole).toInt();
}

int ListModel::setId() {
    return tid;
}

QString ListModel::setName() {
    return tname;
}

QString ListModel::setCity() {
    return tcity;
}

QString ListModel::setAddress() {
    return taddress;
}

QString ListModel::setTime() {
    return ttime;
}

QString ListModel::setColor() {
    return tcolor;
}

QString ListModel::setNotes() {
    return tnotes;
}

void ListModel::ind(int i){
    tid = i;
}

void ListModel::getTask(int ind){
    QSqlQuery query;
    query.prepare("SELECT id, " TABLE_DATE ", " TABLE_NAME ", " TABLE_CITY ", " TABLE_ADDRESS ", " TABLE_TIME ", " TABLE_COLOR ", " TABLE_NOTES " FROM " TABLE " WHERE id = :ID;");
    query.bindValue(":ID", ind);
    query.exec();
    while (query.next()) {
        tid = query.value(0).toInt();
        tname = query.value(2).toString();
        tcity = query.value(3).toString();
        taddress = query.value(4).toString();
        ttime = query.value(5).toString();
        tcolor = query.value(6).toString();
        tnotes = query.value(7).toString();
    }
}

QStringList ListModel::addressList(QString d){
    QSqlQuery query;
    QStringList tmp;
    query.prepare("SELECT id, " TABLE_DATE ", " TABLE_CITY ", " TABLE_ADDRESS " FROM " TABLE " WHERE " TABLE_DATE " = :DATE;");
    query.bindValue(":DATE", d);
    query.exec();
    while (query.next()) {
        tmp.append(query.value(2).toString() + ", " + query.value(3).toString());
    }
    return tmp;
}

QStringList ListModel::getOldTasks() {
    QSqlQuery query;
    QStringList tmp;
    tmp.append("Press to choose from old tasks");
    query.prepare("SELECT " TABLE_NAME " FROM " TABLE ";");
    query.exec();
    while (query.next()) {
        tmp.append(query.value(0).toString());
    }
    tmp.removeDuplicates();
    return tmp;
}

void ListModel::getOldTask(QString name) {
    if (name == "Press to choose from old tasks") {
        tname = "";
        tcity = "";
        taddress = "";
        ttime = "";
        tcolor = "";
        tnotes = "";
    }
    else {
        QSqlQuery query;
        query.prepare("SELECT id, " TABLE_DATE ", " TABLE_NAME ", " TABLE_CITY ", " TABLE_ADDRESS ", " TABLE_TIME ", " TABLE_COLOR ", " TABLE_NOTES " FROM " TABLE " WHERE " TABLE_NAME " = :Name;");
        query.bindValue(":Name", name);
        query.exec();
        while (query.next()) {
            tname = query.value(2).toString();
            tcity = query.value(3).toString();
            taddress = query.value(4).toString();
            ttime = query.value(5).toString();
            tcolor = query.value(6).toString();
            tnotes = query.value(7).toString();
        }
    }
}

