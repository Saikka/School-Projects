#ifndef LISTMODEL_H
#define LISTMODEL_H

#include <QObject>
#include <QSqlQueryModel>

class ListModel : public QSqlQueryModel
{
    Q_OBJECT
public:
    enum Roles {
        IdRole = Qt::UserRole + 1,
        DateRole,
        NameRole,
        CityRole,
        AddressRole,
        TimeRole,
        ColorRole,
        NotesRole
    };

    explicit ListModel(QObject *parent = 0);

    QVariant data(const QModelIndex & index, int role = Qt::DisplayRole) const;

protected:
    QHash<int, QByteArray> roleNames() const;

signals:

public slots:
    void updateModel(QString date);
    int getId(int row);
    int setId();
    void ind(int i);
    QString setName();
    QString setCity();
    QString setAddress();
    QString setTime();
    QString setColor();
    QString setNotes();
    void getTask(int ind);
    void getOldTask(QString name);
    QStringList addressList(QString date);
    QStringList getOldTasks();

private:
    QString tname;
    QString tcity;
    QString taddress;
    QString ttime;
    QString tcolor;
    QString tnotes;
    int tid;
};


#endif // LISTMODEL_H
