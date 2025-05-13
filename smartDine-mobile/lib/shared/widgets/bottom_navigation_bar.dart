import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class NavButton extends StatelessWidget {
  final IconData icon;
  final String label;
  final bool selected;
  final VoidCallback onTap;

  const NavButton({
    Key? key,
    required this.icon,
    required this.label,
    this.selected = false,
    required this.onTap,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final color = selected ? AppColors.accent : AppColors.label;
    return Expanded(
      child: InkWell(
        onTap: onTap,
        child: SizedBox(
          height: double.infinity,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(icon, color: color),
              const SizedBox(height: 4),
              Text(label, style: Theme.of(context).textTheme.bodySmall?.copyWith(color: color)),
            ],
          ),
        ),
      ),
    );
  }
}

class PrimaryBottomNavBar extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onTap;

  const PrimaryBottomNavBar({Key? key, required this.currentIndex, required this.onTap})
    : super(key: key);

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final height = screenWidth * (72 / 375); // Responsive: 72pt on a 375pt-wide design

    return SizedBox(
      width: double.infinity,
      height: height,
      child: Material(
        color: Colors.white,
        elevation: 4,
        child: Row(
          children: [
            NavButton(
              icon: Icons.home,
              label: 'Home',
              selected: currentIndex == 0,
              onTap: () => onTap(0),
            ),
            NavButton(
              icon: Icons.search,
              label: 'Search',
              selected: currentIndex == 1,
              onTap: () => onTap(1),
            ),
            NavButton(
              icon: Icons.event_seat,
              label: 'Seat',
              selected: currentIndex == 2,
              onTap: () => onTap(2),
            ),
            NavButton(
              icon: Icons.assistant,
              label: 'Assistant',
              selected: currentIndex == 3,
              onTap: () => onTap(3),
            ),
            NavButton(
              icon: Icons.history,
              label: 'Activity',
              selected: currentIndex == 4,
              onTap: () => onTap(4),
            ),
          ],
        ),
      ),
    );
  }
}
