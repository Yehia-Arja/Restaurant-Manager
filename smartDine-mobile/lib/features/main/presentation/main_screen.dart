import 'package:flutter/material.dart';
import 'package:mobile/features/home/presentation/screens/home_pscreen.dart';
import 'package:mobile/features/search/presentation/screens/search_sreen.dart';
import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({super.key});

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;

  final List<Widget> _screens = [
    const HomePage(),
    const SearchPage(),
    Placeholder(), // Seat
    Placeholder(), // Assistant
    Placeholder(), // Activity
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _screens[_currentIndex],
      bottomNavigationBar: PrimaryBottomNavBar(
        currentIndex: _currentIndex,
        onTap: (index) => setState(() => _currentIndex = index),
      ),
    );
  }
}
