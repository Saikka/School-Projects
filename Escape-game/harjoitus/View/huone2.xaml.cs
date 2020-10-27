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
    public partial class huone2 : Window
    {
        Huone huone = new Huone();
        Avain avain1 = new Avain { KeyNumber = 1};
        Avain avain2 = new Avain { KeyNumber = 2};
        Avain avain3 = new Avain { KeyNumber = 3};
        Esine tuoli1 = new Esine();
        Esine tuoli2 = new Esine();
        Esine kaktus = new Esine();
        Esine paperi = new Esine();
        Esine vihko = new Esine();
        System.Windows.Threading.DispatcherTimer timer = new System.Windows.Threading.DispatcherTimer();
        int time = 0;

        public huone2()
        {
            InitializeComponent();
            IniMyStuff();
            TimerWork();         
        }

        private void IniMyStuff()
        {
            huone = Toiminta.ReadFromFile();
            message.Text = huone.IsSavedGame.ToString();
            if (huone.IsSavedGame == false)
            {
                huone.RoomNumber = 2;
                Toiminta.NewGame(huone, avain1, avain2, avain3, message);
            }
            else
            {
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
            huone3 h = new harjoitus.View.huone3();
            this.Close();
            h.ShowDialog();

        }
        #endregion

        #region furniture's work
        private void OnChair1Click(object sender, RoutedEventArgs e)
        {
            tuoli1.MoveRight(chair1, 150);
        }
        private void OnChair2Click(object sender, RoutedEventArgs e)
        {
            bool tmp = vihko.IsMoved;
            vihko.IsMoved = tuoli2.IsMoved;
            tuoli2.MoveLeft(chair2, 50);
            vihko.MoveLeft(copybook, 50);
            vihko.IsMoved = tmp;
        }
        private void OnCopybookClick(object sender, RoutedEventArgs e)
        {
            vihko.MoveLeft(copybook, 20);
        }
        private void OnCactusClick(object sender, RoutedEventArgs e)
        {
            kaktus.MoveDownLeft(cactus, 20, 30);
        }
        private void OnPaperClick(object sender, RoutedEventArgs e)
        {
            paperi.MoveDownRight(paper, 60, 40);
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
            if (kaktus.IsMoved == false)
                kaktus.MoveDownLeft(cactus, 20, 30);
            else
            {
                avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint2Click(object sender, RoutedEventArgs e)
        {
            avain2.HintDisappear(hint2);
            if (paperi.IsMoved == false)
                paperi.MoveDownRight(paper, 60, 40);
            else
            {
                avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint3Click(object sender, RoutedEventArgs e)
        {
            avain3.HintDisappear(hint3);
            if (tuoli1.IsMoved == false)
                tuoli1.MoveRight(chair1, 150);
            else
            {
                avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
            }
        }
        #endregion
    }
}
