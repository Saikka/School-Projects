using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Xml.Serialization;
using System.IO;
using System.Media;
using System.Windows.Threading;
using harjoitus.View;

namespace harjoitus.Model
{
    public class Huone
    {
        public int RoomNumber { get; set; }
        public int KeyAmount { get; set; }
        public int Time { get; set; }
        public bool IsSavedGame { get; set; }
        public List<Avain> Avaimet { get; set; }
        public Huone()
        {
            Avaimet = new List<Avain>();
        }
    }

//  all furniture's work
    public class Esine
    {
        public string Image { get; set; }
        public bool IsMoved { get; set; }
        SoundPlayer action = new System.Media.SoundPlayer(Properties.Resources.action);
        public void MoveRight(Button myButton, int x)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + x);
                IsMoved = true;
            }
            else
            {
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - x);
                IsMoved = false;
            }
        }
        public void MoveLeft(Button myButton, int x)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - x);
                IsMoved = true;
            }
            else
            {
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + x);
                IsMoved = false;
            }
        }
        public void MoveUp(Button myButton, int x)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                IsMoved = false;
            }
        }
        public void MoveDown(Button myButton, int x)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                IsMoved = false;
            }
        }
        public void MoveDownLeft(Button myButton, int x, int y)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - y);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + y);
                IsMoved = false;
            }
        }
        public void MoveDownRight(Button myButton, int x, int y)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + y);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - y);
                IsMoved = false;
            }
        }
        public void MoveUpRight(Button myButton, int x, int y)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + y);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - y);
                IsMoved = false;
            }
        }
        public void MoveUpLeft(Button myButton, int x, int y)
        {
            action.Play();
            if (IsMoved == false)
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) - x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) - y);
                IsMoved = true;
            }
            else
            {
                Canvas.SetTop(myButton, Canvas.GetTop(myButton) + x);
                Canvas.SetLeft(myButton, Canvas.GetLeft(myButton) + y);
                IsMoved = false;
            }
        }
    }

    public class Avain : Esine
    {
        public int KeyNumber { get; set; }
        public bool IsFound { get; set; }
        public bool IsHint { get; set; }
        public void KeyDisappear(Huone h, Button myButton, Image i1, Image i2, Image i3, TextBlock m)
        {
            SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.success);
            audio.Play();
            myButton.Visibility = Visibility.Hidden;
            IsFound = true;
            h.KeyAmount++;
            Toiminta.MenuKeys(h.KeyAmount, i1, i2, i3);
            Toiminta.MessageWork(h.KeyAmount, m);
        }
        public void HintAppear(Button myButton)
        {
            myButton.Visibility = Visibility.Visible;
            IsHint = true;
        }
        public void HintDisappear(Button myButton)
        {
            SoundPlayer action = new System.Media.SoundPlayer(Properties.Resources.action);
            action.Play();
            myButton.Visibility = Visibility.Hidden;
            IsHint = false;
        }
        public void NewKey()
        {
            IsFound = false;
            IsHint = false;
        }
    }

//work, what is done by some button
    public static class Toiminta
    {
        const int maxtime = 31;
        public static void MenuKeys(int n, Image b1, Image b2, Image b3)
        {
            switch (n)
            {
                case 1:
                    b1.Visibility = Visibility.Visible;
                    break;
                case 2:
                    b1.Visibility = Visibility.Visible;
                    b2.Visibility = Visibility.Visible;
                    break;
                case 3:
                    b1.Visibility = Visibility.Visible;
                    b2.Visibility = Visibility.Visible;
                    b3.Visibility = Visibility.Visible;
                    break;
                default:
                    break;
            }
        }
        public static void MessageWork(int n, TextBlock m)
        {
            switch (n)
            {
                case 0:
                    m.Text = "Find 3 keys to get out of the room.";
                    break;
                case 1:
                    m.Text = "Still 2 keys to go!";
                    break;
                case 2:
                    m.Text = "Only 1 key to go!";
                    break;
                case 3:
                    m.Text = "All keys are found! You can get out of the room!";
                    break;
            }
        }
        public static void Save(Huone huone)
        {
            try
            {
                Stream writeStream = new FileStream("Huone.bin", FileMode.Create, FileAccess.Write, FileShare.None);
                XmlSerializer serializer = new XmlSerializer(typeof(Huone));
                serializer.Serialize(writeStream, huone);
                writeStream.Close();
            }
            catch (UnauthorizedAccessException)
            {
                MessageBox.Show("Can't open file for writing (UnauthorizedAccessException)");
            }
            catch (ArgumentNullException)
            {
                MessageBox.Show("Opened stream is null (ArgumentNullException)");
            }
            catch (ArgumentException)
            {
                MessageBox.Show("Opened stream is not writable (ArgumentException)");
            }
            catch (IOException)
            {
                MessageBox.Show("An IO error happend (IOException)");
            }
            catch (Exception)
            {
                MessageBox.Show("Some other exception happend (Exception)");
            }
        }
        public static Huone ReadFromFile()
        {
            try
            {
                Huone huone = new Model.Huone();
                Stream openStream = new FileStream("Huone.bin", FileMode.Open, FileAccess.Read, FileShare.Read);
                XmlSerializer serializer = new XmlSerializer(typeof(Huone));
                huone = serializer.Deserialize(openStream) as Huone;
                openStream.Close();
                return huone;
            }
            catch (FileNotFoundException)
            {
                MessageBox.Show("File not found (FileNotFoundException)");
                return null;
            }
        }
        public static void DoorWork(int n, TextBlock text, Button b1, Button b2, DispatcherTimer timer)
        {
            if (n != 3)
            {
                text.Text = "Not enough keys!";
                SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.fail);
                audio.Play();
            }
            else
            {
                timer.Stop();
                SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.door);
                audio.Play();
                b1.Visibility = Visibility.Hidden;
                b2.Visibility = Visibility.Visible;       
            }
        }
        public static void HelpWork(Avain a1, Avain a2, Avain a3, Button b1, Button b2, Button b3, TextBlock m)
        {
            SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
            click.Play();
            if (a1.IsFound == false)
            {
                if (a1.IsHint == false)
                    a1.HintAppear(b1);
                else
                {
                    a1.HintAppear(b1);
                    m.Text = "You can't see next hint until you take this one!";
                    SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.fail);
                    audio.Play();
                }
            }
            else if (a2.IsFound == false)
            {
                if (a2.IsHint == false)
                    a2.HintAppear(b2);
                else
                {
                    a2.HintAppear(b2);
                    m.Text = "You can't see next hint until you take this one!";
                    SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.fail);
                    audio.Play();
                }
            }
            else if (a3.IsFound == false)
            {
                if (a3.IsHint == false)
                    a3.HintAppear(b3);
                else
                {
                    a3.HintAppear(b3);
                    m.Text = "You can't see next hint until you take this one!";
                    SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.fail);
                    audio.Play();
                }
            }
        }
        public static void NewGame(Huone h, Avain a1, Avain a2, Avain a3, TextBlock m)
        {
            a1.NewKey();
            a2.NewKey();
            a3.NewKey();
            h.Avaimet.Add(a1);
            h.Avaimet.Add(a2);
            h.Avaimet.Add(a3);
            h.KeyAmount = 0;
            Toiminta.MessageWork(h.KeyAmount, m);
        }
        public static void LoadGame(Huone h, Avain a1, Avain a2, Avain a3, Button b1, Button b2, Button b3, Image i1, Image i2, Image i3, TextBlock m)
        {
            if (a1.IsFound == true)
            {
                b1.Visibility = Visibility.Hidden;
                a1.IsFound = true;
            }
            if (a2.IsFound == true)
            {
                b2.Visibility = Visibility.Hidden;
                a2.IsFound = true;
            }
            if (a3.IsFound == true)
            {
                b3.Visibility = Visibility.Hidden;
                a3.IsFound = true;
            }
            MenuKeys(h.KeyAmount, i1, i2, i3);
            MessageWork(h.KeyAmount, m);
        }
        public static void Exit(Huone h, Window w)
        {
            SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
            click.Play();
            MainWindow main = new harjoitus.View.MainWindow();
            w.Close();
            main.ShowDialog();
        }
        public static void ExitPause(int n, Window w)
        {
            SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
            click.Play();
            switch (n)
            {
                case 1:
                    huone1 main1 = w.Owner as huone1;
                    MainWindow h1 = new harjoitus.View.MainWindow();
                    w.Close();
                    main1.Close();
                    h1.ShowDialog();
                    break;
                case 2:
                    huone2 main2 = w.Owner as huone2;
                    MainWindow h2 = new harjoitus.View.MainWindow();
                    w.Close();
                    main2.Close();
                    h2.ShowDialog();
                    break;
                case 3:
                    huone3 main3 = w.Owner as huone3;
                    MainWindow h3 = new harjoitus.View.MainWindow();
                    w.Close();
                    main3.Close();
                    h3.ShowDialog();
                    break;
                case 4:
                    huone4 main4 = w.Owner as huone4;
                    MainWindow h4 = new harjoitus.View.MainWindow();
                    w.Close();
                    main4.Close();
                    h4.ShowDialog();
                    break;
                case 5:
                    huone5 main5 = w.Owner as huone5;
                    MainWindow h5 = new harjoitus.View.MainWindow();
                    w.Close();
                    main5.Close();
                    h5.ShowDialog();
                    break;
            }
        }
        public static void Pause(Window w, DispatcherTimer timer)
        {
            SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
            click.Play();
            timer.Stop();
            tauko t = new tauko();
            t.Owner = w;
            t.ShowDialog();
        }
        public static void Continue(int n, Window w)
        {
            SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
            click.Play();
            switch (n)
            {
                case 1:
                    huone1 main1 = w.Owner as huone1;
                    if (main1 != null)
                    {
                        main1.TimerStart();
                    }
                    break;
                case 2:
                    huone2 main2 = w.Owner as huone2;
                    if (main2 != null)
                    {
                        main2.TimerStart();
                    }
                    break;
                case 3:
                    huone3 main3 = w.Owner as huone3;
                    if (main3 != null)
                    {
                        main3.TimerStart();
                    }
                    break;
                case 4:
                    huone4 main4 = w.Owner as huone4;
                    if (main4 != null)
                    {
                        main4.TimerStart();
                    }
                    break;
                case 5:
                    huone5 main5 = w.Owner as huone5;
                    if (main5 != null)
                    {
                        main5.TimerStart();
                    }
                    break;
            }
            w.Close();
        }
        // work of timer
        public static int Timer(TextBlock t, int time)
        {
            int tmp = maxtime - time;
            t.Text = "0:" + tmp.ToString();
            return tmp;
        }
        public static void TimerWork(int tmp, TextBlock t, Window w, DispatcherTimer timer)
        {
            SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.clock);
            if (tmp < 10)
            {
                t.Foreground = System.Windows.Media.Brushes.Red;
                t.Text = "0:0" + tmp.ToString();
                audio.Play();
            }
            if (tmp == 0)
            {
                audio.Stop();
                timer.Stop();
                pelinHavitys losing = new pelinHavitys();
                w.Close();
                losing.Show();
            }
        }

    }
}

