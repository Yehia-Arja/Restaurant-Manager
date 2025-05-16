import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/features/home/domain/entities/branch.dart';

class BranchSelector extends StatefulWidget {
  final List<Branch> branches;
  final VoidCallback? onNotificationTap;

  const BranchSelector({Key? key, required this.branches, this.onNotificationTap})
    : super(key: key);

  @override
  State<BranchSelector> createState() => _BranchSelectorState();
}

class _BranchSelectorState extends State<BranchSelector> {
  bool _menuOpen = false;

  @override
  Widget build(BuildContext context) {
    final selectedId = context.watch<SelectedBranchCubit>().state;

    Branch current = widget.branches.first;
    if (selectedId != null) {
      final match = widget.branches.where((b) => b.id == selectedId);
      if (match.isNotEmpty) current = match.first;
    }

    return ClipRRect(
      borderRadius: const BorderRadius.only(
        bottomLeft: Radius.circular(12),
        bottomRight: Radius.circular(12),
      ),
      child: Container(
        color: AppColors.accent,
        child: SafeArea(
          bottom: false,
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 15, vertical: 10),
            child: Row(
              children: [
                PopupMenuButton<Branch>(
                  tooltip: 'Select Branch',
                  offset: const Offset(0, 44),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
                  onOpened: () => setState(() => _menuOpen = true),
                  onSelected: (b) {
                    context.read<SelectedBranchCubit>().select(b.id);
                    setState(() => _menuOpen = false);
                  },
                  onCanceled: () => setState(() => _menuOpen = false),
                  itemBuilder:
                      (_) =>
                          widget.branches
                              .map((b) => PopupMenuItem(value: b, child: Text(b.locationName)))
                              .toList(),
                  child: Row(
                    children: [
                      const Icon(Icons.location_on_outlined, color: Colors.white, size: 22),
                      const SizedBox(width: 6),
                      Text(
                        current.locationName,
                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: Colors.white,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      const SizedBox(width: 6),
                      Icon(
                        _menuOpen ? CupertinoIcons.chevron_up : CupertinoIcons.chevron_down,
                        color: Colors.white,
                        size: 11,
                      ),
                    ],
                  ),
                ),
                const Spacer(),
                IconButton(
                  iconSize: 20,
                  icon: const Icon(Icons.person, color: Colors.white),
                  onPressed: widget.onNotificationTap,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
