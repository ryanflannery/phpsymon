<?php
/*
 * Copyright (c) 2008 Ryan Flannery
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDERS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 */


/* The following files defines a large associative array called
 * 'symuxFormat' which defines the format for each datum phpSymon
 * reads.  These formats are taken directly from "man symux(8)", in the
 * LISTENERS section, under "Data Formats".  Please check that manual
 * for more information on the format below.
 */


/* NOTE: If you are working with the following formats, you should pay
 * close attention to the following line symux(8):
 *      "The format is: symon-version : symon-host-ip : stream-name : stream-
 *       argument : timestamp : data "
 * For each datum that is read from a symon stream, there is a 'name' and
 * 'timestamp' field preceeding the data.  For network interfaces or hard-
 * drives, the name is simply the name of that device (lo0, sd0, etc.)
 * For datums such as 'mem' (memory), 'pf', and 'mbuf', the name field is
 * blank.
 */

$symuxFormat = array();

// format for each cpu datum
$symuxFormat['cpu'] = array('name', 'timestamp',
   'user', 'nice', 'system', 'interrupt', 'idle');

// format for the memory datum
$symuxFormat['mem'] = array('name', 'timestamp',
   'real_active', 'real_total', 'free', 'swap_used', 'swap_total');

// format for each network interface datum
$symuxFormat['if'] = array('name', 'timestamp',
   'packets_in', 'packets_out', 'bytes_in',
   'bytes_out', 'multicasts_in', 'multicasts_out', 'errors_in',
   'errors_out', 'collisions', 'drops');

// pre-OpenBSD 3.5 io/disk counter datums (one for each drive)
$symuxFormat['io1'] = array('name', 'timestamp',
   'total_transfers', 'total_seeks', 'total_bytes');

// format for each disk-counter datum
$symuxFormat['io'] = array('name', 'timestamp',
   'total_rxfer', 'total_wxfer', 'total_seeks',
   'total_rbytes', 'total_wbytes');

// io2 is an alias for io
$symuxFormat['io2'] = &$symuxFormat['io'];

// format for pf datum
$symuxFormat['pf'] = array('name', 'timestamp',
   'bytes_v4_in', 'bytes_v4_out',
   'bytes_v6_in', 'bytes_v6_out',
   'packets_v4_in_pass', 'packets_v4_in_drop',
   'packets_v4_out_pass', 'packets_v4_out_drop',
   'packets_v6_in_pass', 'packets_v6_in_drop',
   'packets_v6_out_pass', 'packets_v6_out_drop',
   'states_entries', 'states_searches', 'states_inserts', 'states_removals',
   'counters_match', 'counters_badoffset', 'counters_fragment',
   'counters_short', 'counters_normalize', 'counters_memory');

// format for the debug datum
$symuxFormat['debug'] = array('name', 'timestamp',
   'debug0', 'debug1', 'debug2', 'debug3', 'debug4', 'debug5', 'debug6',
   'debug7', 'debug8', 'debug9', 'debug10', 'debug11', 'debug12', 'debug13',
   'debug14', 'debug15', 'debug16', 'debug17', 'debug18', 'debug19');

// format for each processor datum
$symuxFormat['proc'] = array('name', 'timestamp',
   'number', 'uticks', 'sticks', 'iticks', 'cpusec', 'cpupct',
   'procsz', 'rsssz');

// format for the mbuf datum
$symuxFormat['mbuf'] = array('name', 'timestamp',
   'totmbufs', 'mt_data', 'mt_oobdata', 'mt_control',
   'mt_header', 'mt_ftable', 'mt_soname', 'mt_soopts', 'pgused', 'pgtotal',
   'totmem', 'totpct', 'm_drops', 'm_wait', 'm_drain');

// format for each sensor datum
$symuxFormat['sensor'] = array('name', 'timestamp', 'value');

// format for each pf altQ queue datum
$symuxFormat['pfq'] = array('name', 'timestamp',
   'sent_bytes', 'sent_packets', 'drop_bytes', 'drop_packets');

// format for each disk-slice free-space datum
$symuxFormat['df'] = array('name', 'timestamp',
   'blocks', 'bfree', 'bavail', 'files', 'ffree', 'synwrites', 'asyncwrites');
?>
