using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using harjoitus.Model;
using System.Media;
using System.Windows.Threading;

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for huone1.xaml
    /// </summary>
    public partial class huone1 : Window
    {
        Huone huone = new Huone();
        Avain avain1 = new Avain { KeyNumber = 1 };
        Avain avain2 = new Avain { KeyNumber = 2 };
        Avain avain3 = new Avain { KeyNumber = 3 };
        Esine lehti = new Esine();
        Esine tuoli = new Esine();
        Esine kirjat1 = new Esine();
        Esine kirjat2 = new Esine();
        Esine kirja1 = new Esine();
        Esine kirja2 = new Esine();
        Esine kirja3 = new Esine();
        Esine kirja4 = new Esine();
        Esine kirja5 = new Esine();
        Esine kirja6 = new Esine();
        Esine kirja7 = new Esine();
        Esine kirja8 = new Esine();
        Esine kirja9 = new Esine();
        Esine kirja10 = new Esine();
        System.Windows.Threading.DispatcherTimer timer = new System.Windows.Threading.DispatcherTimer();
        int time = 0;

        public huone1()
        {
            InitializeComponent();
            IniMyStuff();
            TimerWork();
        }

        private void IniMyStuff()
        {
            huone = Toiminta.ReadFromFile();
            if (huone.IsSavedGame == false)
            {
                // creating new game
                huone.RoomNumber = 1;
                huone.Time = 0;
                Toiminta.NewGame(huone, avain1, avain2, avain3, message);
            }
            else
            {
                // loading game
                foreach (Avain a in huone.Avaimet)
                {
                    if (a.KeyNumber == 1)
                        avain1 = a;
                    else if (a.KeyNumber == 2)
                        avain2 = a;
                    else if (a.KeyNumber == 3)
                        avain3 = a;
                }
                Toiminta.LoadGame(huone, avain1, avain2, avain3, key1, key2, key3, menuKey1, menuKey2, menuKey3, message);
                time = 32 - huone.Time;
            }
        }

        #region Timer's work
        public void TimerWork()
        {
            timer = new DispatcherTimer();
            timer.Tick += new EventHandler(timer_Tick);
            timer.Interval = new TimeSpan(0, 0, 1);
            timer.Start();
        }

        private void timer_Tick(object sender, EventArgs e)
        {
            time++;
            huone.Time = Toiminta.Timer(timeshow, time);
            Toiminta.TimerWork(huone.Time, timeshow, this, timer);
        }

        public void TimerStart()
        {
            timer.Start();
        }

        #endregion

        #region Key's work
        private void OnButton1Click(object sender, RoutedEventArgs e)
        {
            avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
            
        }
        private void OnButton2Click(object sender, RoutedEventArgs e)
        {
            avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
        }
        private void OnButton3Click(object sender, RoutedEventArgs e)
        {
            avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
        }
        #endregion

        #region door's work
        private void OnDoor1Click(object sender, RoutedEventArgs e)
        {
            Toiminta.DoorWork(huone.KeyAmount, message, door1, door2, timer);
        }

        private void OnDoor2Click(object sender, RoutedEventArgs e)
        {
            SoundPlayer doorSound = new System.Media.SoundPlayer(Properties.Resources.door2);
            doorSound.Play();
            huone.IsSavedGame = false;
            Toiminta.Save(huone);
            huone2 h = new harjoitus.View.huone2();
            this.Close();
            h.ShowDialog();
        }
        #endregion

        #region furniture's work
        private void OnNewspaperClick(object sender, RoutedEventArgs e)
        {
            lehti.MoveRight(newspaper, 70);
        }
        private void OnChairClick(object sender, RoutedEventArgs e)
        {
            tuoli.MoveLeft(chair, 100);
        }
        private void OnBooks1Click(object sender, RoutedEventArgs e)
        {
            kirjat1.MoveDown(books1, 70);
        }
        private void OnBooks2Click(object sender, RoutedEventArgs e)
        {
            kirjat2.MoveRight(books2, 50);
        }
        private void OnBook1Click(object sender, RoutedEventArgs e)
        {
            kirja1.MoveDown(book1, 50);
        }
        private void OnBook2Click(object sender, RoutedEventArgs e)
        {
            kirja2.MoveDown(book2, 50);
        }
        private void OnBook3Click(object sender, RoutedEventArgs e)
        {
            kirja3.MoveDown(book3, 50);
        }
        private void OnBook4Click(object sender, RoutedEventArgs e)
        {
            kirja4.MoveDown(book4, 50);
        }
        private void OnBook5Click(object sender, RoutedEventArgs e)
        {
            kirja5.MoveDown(book5, 50);
        }
        private void OnBook6Click(object sender, RoutedEventArgs e)
        {
            kirja6.MoveDown(book6, 50);
        }
        private void OnBook7Click(object sender, RoutedEventArgs e)
        {
            kirja7.MoveDown(book7, 50);
        }
        private void OnBook8Click(object sender, RoutedEventArgs e)
        {
            kirja8.MoveUp(book8, 50);
        }
        private void OnBook9Click(object sender, RoutedEventArgs e)
        {
            kirja9.MoveUp(book9, 50);
        }
        private void OnBook10Click(object sender, RoutedEventArgs e)
        {
            kirja10.MoveUp(book10, 50);
        }
        #endregion

        #region menu button's work

        private void exitButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Exit(huone, this);
        }

        private void pauseButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Save(huone);
            Toiminta.Pause(this, timer);
        }


        private void helpButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.HelpWork(avain1, avain2, avain3, hint1, hint2, hint3, message);
        }
        #endregion

        #region hint's work
        private void OnHint1Click(object sender, RoutedEventArgs e)
        {
            avain1.HintDisappear(hint1);
            if (lehti.IsMoved == false)
                lehti.MoveRight(newspaper, 70);
            else
            {
                avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
            }
         }
        private void OnHint2Click(object sender, RoutedEventArgs e)
        {
            avain2.HintDisappear(hint2);
            if (kirjat1.IsMoved == false)
                kirjat1.MoveDown(books1, 70);
            else
            {
                avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint3Click(object sender, RoutedEventArgs e)
        {
            avain3.HintDisappear(hint3);
            if (kirja2.IsMoved == false)
            {
                kirja2.MoveDown(book2, 50);
                if (kirja3.IsMoved == false)
                    kirja3.MoveDown(book3, 50);
                if (kirja4.IsMoved == false)
                    kirja4.MoveDown(book4, 50);
            }
            else
            {
                avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
            }
        }
        #endregion
    }
}
