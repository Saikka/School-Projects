   M S B A M L   `   `   `  ����D  @harjoitus, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null/clr-namespace:harjoitus.Viewharjoitus.View  5   	       harjoitus.View.huone2   5   	   \ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   .localclr-namespace:harjoitus.View     5   	     � Title$  huone2��5   	   $	��600��6   $
��1000��6%   .��5	      � .+�5
   
   �� .+�5      �� ���	#FFF1DAA8 �� Orientation$ 
Horizontal=�60   .+�5      �� -   5         ��Name$ pauseButton��5      $��Pause��6.   $
��Left=�6?   $��51��6Z   $	��111��6f   $��26(�6r   $
��Bold"�6�    � Cursor$	 Pen��6�   ��5      �� 5       �� EndPoint$ 0.5,1&�6.    �� 
StartPoint$ 0.5,0&�6?   .��5      �  � Color$ Black��6+    � Offset$ 0Q�69   � 5      $ 	#FFD6970F��6+   $ 1Q�6=   5      5      �� 5      -   5         ��Name$ message��5      $	��428��6-   $��20(�69   	 �� TextAlignment$	 Center=�6G   �� 5      -   5        $ timeshow��5      $��89��6.   $	 Center=�69   $��30(�6P   $
��Bold"�6^   �� 5      $	��128��6   .+�5      �� $6��0pack://application:,,,/Resources/KeyNotFound.png��6   
 �� Left$
 0��6V   
 �� Top$ 3��6f   $��48��6u   $��47��6�   �� 5      $6��0pack://application:,,,/Resources/KeyNotFound.png��6   $
 40��6V   $ 3��6g   $��48��6v   $��47��6�   �� 5      $6��0pack://application:,,,/Resources/KeyNotFound.png��6   $
 80��6V   $ 3��6g   $��48��6v   $��47��6�   �� 5      -   5        $��menuKey1��5      $3��-pack://application:,,,/Resources/KeyFound.png��6,   $
 0��6c   $ 3��6s   $��48��6�   $��47��6�   $y�Hidden=�6�   �� 5      -   5        $��menuKey2��5      $3��-pack://application:,,,/Resources/KeyFound.png��6,   $
 40��6c   $ 3��6t   $��48��6�   $��47��6�   $y�Hidden=�6�   �� 5      -   5        $��menuKey3��5      $3��-pack://application:,,,/Resources/KeyFound.png��6,   $
 80��6c   $ 3��6t   $��48��6�   $��47��6�   $y�Hidden=�6�   5      �� 5      -   5        $ 
helpButton��5      $��	10,0,20,0q�6-   $��?��6@   $��26(�6L   $
��Bold"�6Z   $��95��6l   $	 Pen��6�   ��5      �� 5       $ 0.5,1&�6.   $ 0.5,0&�6?   .��5!      � $ Black��6+   $ 0Q�69   � 5"      $ 	#FFD6970F��6+   $ 1Q�6=   5#      5%      �� 5&      -   5        $ 
exitButton��5&      $
��Exit��6-   $
��Left=�6<   $��51��6W   $	��114��6c   $��26(�6o   $
��Bold"�6}   $	 Pen��6�   ��5'      �� 5(      $ 0.5,1&�6.   $ 0.5,0&�6?   .��5)      � $ Black��6+   $ 0Q�69   � 5*      $ 	#FFD6970F��6+   $ 1Q�6=   5+      5-      5.      �� 5/      .+�50      �� $,��&pack://application:,,,/Resources/2.png��6   $	��997��6H   $	��521��6T   $ 3��6a   �� 51      -	   5        $
��key1��51      $	
 103��6<   $	 272��6N   $
 Hand��6�   $��30��6�   $��21��6�    J� RenderTransformOrigin$ 0.5,0.5&�6�   ��6_   Z� ��6u   Z� ��6�   Z� z�52      V� 53      .~�54      �� �� 55      �� 56       �� Angle$ -42.742Q�6.   T� 57      58      .��5:      �� $.��(pack://application:,,,/Resources/key.png��6   $��29��6N   $��19��6Y   6g   5;      �� 5<      -
   5        $
��key2��5<      $
 95��6<   $	 415��6M   $
 Hand��6�   $��26��6�   $��21��6�   ��6^   Z� ��6t   Z� ��6�   Z� .��5=      �� $.��(pack://application:,,,/Resources/key.png��6   $��26��6N   $��19��6Y   6g   5>      �� 5?      -   5        $
��key3��5?      $	
 360��6<   $	 313��6N   $
 Hand��6�   $��30��6�   $��23��6�   ��6_   Z� ��6u   Z� ��6�   Z� .��5@      �� $.��(pack://application:,,,/Resources/key.png��6   $��27��6N   $��22��6Y   $ 0.5,0.5&�6e   z�5A      V� 5B      .~�5C   "   �� �� 5D   "   �� 5E   "   $ -18.097Q�62   T� 5F   "   5G      5I      5J      �� 5K      -   5        $��door2��5K      $	
 480��6;   $ 99��6M   $
 Hand��6�   $y�Hidden=�6�   ��6]   Z� ��6s   Z� ��6�   Z� .��5L      �� $5��/pack://application:,,,/Resources/doorinside.png��6   $	��280��6U   6d   5M      �� 5N      -   5        $��door1��5N      $	
 560��6;   $	 108��6M   $
 Hand��6�   ��6^   Z� ��6t   Z� ��6�   Z� .��5O      �� $/��)pack://application:,,,/Resources/door.png��6   $	��259��6O   $	��158��6\   6j   5P      �� 5Q      -   5        $��paper��5Q      $
 80��6;   $	 400��6L   $
 Hand��6�   $��48��6�   $��47��6�   ��6]   Z� ��6s   Z� ��6�   Z� .��5R      �� $0��*pack://application:,,,/Resources/paper.png��6   $��38��6P   $��47��6\   6i   5S      �� 5T      -   5        $��cactus��5T      $
 92��6=   $	 197��6N   $
 Hand��6�   $	��101��6�   $��52��6�   ��6_   Z� ��6u   Z� ��6�   Z� .��5U      �� $1��+pack://application:,,,/Resources/cactus.png��6   $��93��6Q   $��52��6]   6j   5V      �� 5W      -   5        $��chair1��5W      $	
 280��6=   $	 268��6O   $
 Hand��6�   $	��233��6�   $	��142��6�   ��6`   Z� ��6v   Z� ��6�   Z� .��5X      �� $0��*pack://application:,,,/Resources/chair.png��6   $	��218��6P   $	��132��6]   6k   5Y      �� 5Z      -   5        $��chair2��5Z      $	
 603��6=   $	 285��6O   $
 Hand��6�   $	��236��6�   $	��142��6�   ��6`   Z� ��6v   Z� ��6�   Z� .��5[      �� $1��+pack://application:,,,/Resources/chair2.png��6   $	��218��6Q   $	��164��6^   6l   5\      �� 5]      -   5        $��copybook��5]      $	
 658��6A   $	 380��6S   $
 Hand��6�   $��51��6�   $��66��6�   ��6d   Z� ��6z   Z� ��6�   Z� .��5^      �� $3��-pack://application:,,,/Resources/copybook.png��6   $��50��6S   $��55��6_   6l   5_      �� 5`      -   5        $��hint1��5`      $
 71��6;   $	 235��6L   $
 Hand��6�   $��71��6�   $��97��6�   $ 0.5,0.5&�6�   $y�Hidden=�6�   ��6]   Z� ��6s   Z� ��6�   Z� .��5a      �� $/��)pack://application:,,,/Resources/hint.png��6   $��89��6O   $��66��6Z   6h   5b      �� 5c      -   5        $��hint2��5c      $
 70��6;   $	 400��6L   $
 Hand��6�   $��49��6�   $��67��6�   $y�Hidden=�6�   ��6]   Z� ��6s   Z� ��6�   Z� .��5d      �� $/��)pack://application:,,,/Resources/hint.png��6   $��60��6O   $��66��6Z   6h   5e      �� 5f      -   5        $��hint3��5f      $	
 345��6;   $	 260��6M   $
 Hand��6�   $��98��6�   $	��112��6�   $y�Hidden=�6�   ��6^   Z� ��6t   Z� ��6�   Z� .��5g      �� $/��)pack://application:,,,/Resources/hint.png��6   $	��120��6O   $��79��6[   6i   5h      5i      5j      5k      5l      