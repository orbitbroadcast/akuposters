"use strict";
var phpFreeChat = function(pfc, $, window) {
        function Plugin(element, options) {
            options = $.extend({}, options), options && options.serverUrl || (options.serverUrl = defaults.serverUrl), options && options.packageUrl || (options.packageUrl = options.serverUrl + "/../package.json"), options && options.serverCheckUrl || (options.serverCheckUrl = options.serverUrl + "/../check.php"), this.element = element, this.options = $.extend({}, defaults, options), this._defaults = defaults, this._name = pluginName, pfc.init(this)
        }
        var pluginName = "phpfreechat";
        window.document;
        var defaults = {
            serverUrl: "../server",
            packageUrl: "../package.json",
            serverCheckUrl: "../check.php",
            loaded: null,
            loadTestData: !1,
            refresh_delay: 5e3,
            focus_on_connect: !0,
            check_backlink: !0,
            show_powered_by: !0,
            use_post_wrapper: !0,
            check_server_config: !0,
            tolerated_network_errors: 5,
            skip_intro: !1,
            skip_auth: !1
        };
        return $.fn[pluginName] = function(options) {
            return this.each(function() {
                $.data(this, "plugin_" + pluginName) || $.data(this, "plugin_" + pluginName, new Plugin(this, options))
            })
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.login = function(credentials, callback) {
            var h = credentials ? {
                    "Pfc-Authorization": "Basic " + pfc.base64.encode(credentials.login + ":" + credentials.password)
                } : {},
                d = credentials ? {
                    email: credentials.email
                } : null;
            $.ajax({
                type: "GET",
                url: pfc.options.serverUrl + "/auth",
                headers: h,
                data: d
            }).done(function(userdata) {
                $(pfc.element).trigger("pfc-login", [pfc, userdata]), callback && callback(null, userdata)
            }).error(function(err) {
                try {
                    err = JSON.parse(err.responseText)
                } catch (e) {}
                err && err.error && 40301 != err.errorCode ? pfc.showAuthForm(err.error) : pfc.showAuthForm(), callback && callback(err)
            })
        }, pfc.logout = function(callback) {
            $.ajax({
                type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                url: pfc.options.serverUrl + "/auth",
                data: pfc.options.use_post_wrapper ? {
                    _METHOD: "DELETE"
                } : null
            }).done(function(userdata) {
                $(pfc.element).trigger("pfc-logout", [pfc, userdata]), callback && callback(null, userdata)
            }).error(function(err) {
                callback && callback(err)
            })
        }, pfc.showAuthForm = function(msg) {
            pfc.modalbox.open('<form>  <div class="popup-login">    <input type="text" name="login" placeholder="Login" value="'+document.getElementById('hdnusername').value+'"/><br/>    <input type="submit" name="submit" value="Sign in" />' + (msg ? "<p>" + msg + "</p>" : "") + "  </div>" + "</form>").submit(function() {
                
                var login = $(this).find("[name=login]").attr("value"),
                    password = $(this).find("[name=password]").attr("value"),
                    email = $(this).find("[name=email]").attr("value");
                return login ? (pfc.login({
                    login: login,
                    password: password,
                    email: email
                }), pfc.modalbox.close(!0), !1) : !1
            }).find("[name=login]").focus()
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.getNameFromCid = function(cid) {
            return pfc.channels[cid].name
        }, pfc.getCidFromName = function(channel) {
            var result = null;
            return $.each(pfc.channels, function(cid, chan) {
                channel === chan.name && (result = cid)
            }), result
        }, pfc.addUidToCid = function(uid, cid) {
            var idx = $.inArray(uid, pfc.channels[cid].users);
            return -1 === idx ? (pfc.channels[cid].users.push(uid), !0) : !1
        }, pfc.removeUidFromCid = function(uid, cid) {
            var idx = $.inArray(uid, pfc.channels[cid].users);
            return -1 === idx ? !1 : (pfc.channels[cid].users.splice(idx, 1), pfc.channels[cid].op.splice(idx, 1), !0)
        }, pfc.addUidToCidOp = function(uid, cid) {
            var idx = $.inArray(uid, pfc.channels[cid].op);
            return -1 === idx ? (pfc.addUidToCid(uid, cid), pfc.channels[cid].op.push(uid), !0) : !1
        }, pfc.removeUidFromCidOp = function(uid, cid) {
            var idx = $.inArray(uid, pfc.channels[cid].op);
            return -1 === idx ? !1 : (pfc.channels[cid].op.splice(idx, 1), !0)
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.commands = $.extend({}, pfc.commands), pfc.commands.ban = {
            usage: '/ban "<username>" ["reason"]',
            longusage: '/ban ["#<channel>"] "<username>" ["reason"]',
            regexp: [/^"([^#][^"]*?)"$/, /^"([^#][^"]*?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)" +"([^"]+?)"$/],
            regexp_ids: [{
                1: "username"
            }, {
                1: "username",
                2: "reason"
            }, {
                1: "channel",
                2: "username"
            }, {
                1: "channel",
                2: "username",
                3: "reason"
            }],
            send: function(cmd_arg) {
                var name64 = pfc.base64.encode(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/ban/" + name64,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "PUT",
                        reason: cmd_arg.reason
                    } : {
                        reason: cmd_arg.reason
                    }
                }).done(function() {
                    pfc.commands.ban.receive({
                        type: "ban",
                        sender: pfc.uid,
                        body: {
                            opname: pfc.users[pfc.uid].name,
                            name: cmd_arg.username,
                            reason: cmd_arg.reason,
                            kickban: !1
                        },
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1];
                pfc.users[pfc.uid].name == msg.body.name ? (msg.body.kickban && pfc.clearUserList(), msg.body = "You were " + (msg.body.kickban ? "kick" : "") + "banned by " + msg.body.opname + " from #" + pfc.getNameFromCid(cid) + " for " + (msg.body.reason ? 'the reason "' + msg.body.reason + '"' : "no reason"), pfc.appendMessage(msg)) : (msg.body.kickban && (pfc.removeUidFromCid(pfc.getUidFromName(msg.body.name), cid), pfc.removeUser(pfc.getUidFromName(msg.body.name))), msg.body = msg.body.name + " was " + (msg.body.kickban ? "kick" : "") + "banned by " + msg.body.opname + " from this channel" + " for " + (msg.body.reason ? 'the reason "' + msg.body.reason + '"' : "no reason"), pfc.appendMessage(msg))
            }
        }, pfc.commands.kickban = {
            usage: '/kickban "<username>" ["reason"]',
            longusage: '/kickban ["#<channel>"] "<username>" ["reason"]',
            regexp: [/^"([^#][^"]*?)"$/, /^"([^#][^"]*?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)" +"([^"]+?)"$/],
            regexp_ids: [{
                1: "username"
            }, {
                1: "username",
                2: "reason"
            }, {
                1: "channel",
                2: "username"
            }, {
                1: "channel",
                2: "username",
                3: "reason"
            }],
            send: function(cmd_arg) {
                var name64 = pfc.base64.encode(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/ban/" + name64,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "PUT",
                        reason: cmd_arg.reason,
                        kickban: !0
                    } : {
                        reason: cmd_arg.reason
                    }
                }).done(function() {
                    pfc.commands.ban.receive({
                        type: "ban",
                        sender: pfc.uid,
                        body: {
                            opname: pfc.users[pfc.uid].name,
                            name: cmd_arg.username,
                            reason: cmd_arg.reason,
                            kickban: !0
                        },
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: pfc.commands.ban.receive
        }, pfc.commands.unban = {
            usage: '/unban "<username>"',
            longusage: '/unban ["#<channel>"] "<username>"',
            regexp: [/^"([^#][^"]*?)"$/, /^"#([^"]+?)" +"([^"]+?)"$/],
            regexp_ids: [{
                1: "username"
            }, {
                1: "channel",
                2: "username"
            }],
            send: function(cmd_arg) {
                var name64 = pfc.base64.encode(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/ban/" + name64,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "DELETE"
                    } : {}
                }).done(function() {
                    pfc.commands.unban.receive({
                        type: "unban",
                        sender: pfc.uid,
                        body: {
                            opname: pfc.users[pfc.uid].name,
                            name: cmd_arg.username
                        },
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1];
                msg.body = msg.body.name + " was unbanned by " + msg.body.opname + " from #" + pfc.getNameFromCid(cid), pfc.appendMessage(msg)
            }
        }, pfc.commands.banlist = {
            usage: "/banlist",
            longusage: '/banlist ["#<channel>"]',
            regexp: [/^$/, /^"#([^"]+?)"$/],
            regexp_ids: [{}, {
                1: "channel"
            }],
            send: function(cmd_arg) {
                $.ajax({
                    type: "GET",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/ban/"
                }).done(function(banlist) {
                    pfc.commands.banlist.receive({
                        type: "banlist",
                        sender: pfc.uid,
                        body: banlist,
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    banlist_txt = [];
                $.each(msg.body, function(key, value) {
                    value.timestamp = new Date(1e3 * value.timestamp), banlist_txt.push(key + " (banned by " + value.opname + " for " + (value.reason ? 'the reason "' + value.reason + '"' : "no reason") + " on " + value.timestamp + ")")
                }), msg.body = banlist_txt.length > 0 ? "Banished list on #" + pfc.getNameFromCid(cid) + "\n  - " + banlist_txt.join("\n  - ") : "Empty banished list on  #" + pfc.getNameFromCid(cid), pfc.appendMessage(msg)
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.commands = $.extend({}, pfc.commands), pfc.commands.join = {
            help: "",
            usage: '/join "#<channel>"',
            longusage: '/join "#<channel>"',
            regexp: [/^"#([^"]+?)"$/],
            regexp_ids: [{
                1: "channel"
            }],
            send: function(cmd_arg) {
                cmd_arg.cid = "xxx", $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/users/" + pfc.uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "PUT"
                    } : null
                }).done(function(cinfo) {
                    pfc.channels[cmd_arg.cid] = {
                        name: cmd_arg.cid,
                        users: [],
                        op: []
                    }, pfc.channels[cmd_arg.cid].op = cinfo.op, pfc.clearUserList(), $.each(cinfo.users, function(uid, udata) {
                        pfc.addUidToCid(uid, cmd_arg.cid), pfc.users[uid] = udata, pfc.appendUser(udata)
                    }), pfc.appendMessage({
                        type: "join",
                        sender: pfc.uid,
                        body: "you joined the channel"
                    })
                }).error(function(err) {
                    pfc.displayError(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1];
                pfc.addUidToCid(msg.sender, cid), msg.body.op && pfc.addUidToCidOp(msg.sender, cid), pfc.users[msg.sender] = msg.body.userdata, pfc.appendUser(pfc.users[msg.sender]), pfc.appendMessage(msg)
            }
        }, pfc.commands.leave = {
            help: "",
            usage: '/leave ["#<channel>"]',
            longusage: '/leave ["#<channel>"] ["reason"]',
            regexp: [/^"#([^"]+?)" "([^"]+?)"$/, /^"#([^"]+?)"$/, /^"([^"]+?)"$/, /^$/],
            regexp_ids: [{
                1: "channel",
                2: "reason"
            }, {
                1: "channel"
            }, {
                1: "reason"
            }, {}],
            send: function(cmd_arg) {
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/users/" + pfc.uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "DELETE"
                    } : null
                }).done(function() {
                    pfc.clearUserList(), pfc.appendMessage({
                        type: "leave",
                        sender: pfc.uid
                    })
                }).error(function(err) {
                    pfc.displayError(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1];
                pfc.removeUidFromCid(msg.sender, cid), pfc.removeUser(msg.sender), pfc.appendMessage(msg)
            }
        }, pfc.commands.op = {
            help: "gives operator rights to a user on a channel",
            usage: '/op "<username>"',
            longusage: '/op ["#<channel>"] "<username>"',
            params: ["channel", "username"],
            regexp: [/^("#(.+?)" |)"(.+?)"$/],
            regexp_ids: [{
                2: "channel",
                3: "username"
            }],
            send: function(cmd_arg) {
                var uid = pfc.getUidFromName(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/op/" + uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "PUT"
                    } : null
                }).done(function() {
                    pfc.commands.op.receive({
                        type: "op",
                        sender: pfc.uid,
                        body: uid,
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    op = pfc.users[msg.sender],
                    op_dst = pfc.users[msg.body];
                pfc.addUidToCidOp(op_dst.id, cid), msg.body = op.name + " gave operator rights to " + op_dst.name, pfc.appendMessage(msg), pfc.removeUser(op_dst.id), pfc.appendUser(op_dst.id)
            }
        }, pfc.commands.deop = {
            help: "removes operator rights to a user on a channel",
            usage: '/deop "<username>"',
            longusage: '/deop ["#<channel>"] "<username>"',
            params: ["channel", "username"],
            regexp: [/^("#(.+?)" |)"(.+?)"$/],
            regexp_ids: [{
                2: "channel",
                3: "username"
            }],
            send: function(cmd_arg) {
                var uid = pfc.getUidFromName(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/op/" + uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "DELETE"
                    } : null
                }).done(function() {
                    pfc.commands.deop.receive({
                        type: "deop",
                        sender: pfc.uid,
                        body: uid,
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    deop = pfc.users[msg.sender],
                    deop_dst = pfc.users[msg.body];
                pfc.removeUidFromCidOp(deop_dst.id, cid), msg.body = deop.name + " removed operator rights to " + deop_dst.name, pfc.appendMessage(msg), pfc.removeUser(deop_dst.id), pfc.appendUser(deop_dst.id)
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.commands = $.extend({}, pfc.commands), pfc.commands.kick = {
            usage: '/kick "<username>" ["reason"]',
            longusage: '/kick ["#<channel>"] "<username>" ["reason"]',
            regexp: [/^"([^#][^"]*?)"$/, /^"([^#][^"]*?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)"$/, /^"#([^"]+?)" +"([^"]+?)" +"([^"]+?)"$/],
            regexp_ids: [{
                1: "username"
            }, {
                1: "username",
                2: "reason"
            }, {
                1: "channel",
                2: "username"
            }, {
                1: "channel",
                2: "username",
                3: "reason"
            }],
            send: function(cmd_arg) {
                var uid = pfc.getUidFromName(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/users/" + uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "DELETE",
                        reason: cmd_arg.reason
                    } : {
                        reason: cmd_arg.reason
                    }
                }).done(function() {
                    pfc.commands.kick.receive({
                        type: "kick",
                        sender: pfc.uid,
                        body: {
                            target: uid,
                            reason: cmd_arg.reason
                        },
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    kicker = pfc.users[msg.sender],
                    kicked = pfc.users[msg.body.target];
                pfc.uid == kicked.id ? (pfc.clearUserList(), msg.body = kicker.name + " kicked you from " + pfc.getNameFromCid(cid) + (msg.body.reason ? " [ reason: " + msg.body.reason + "]" : ""), pfc.appendMessage(msg)) : (pfc.removeUidFromCid(kicked.id, cid), msg.body = kicker.name + " kicked " + kicked.name + (msg.body.reason ? " [ reason: " + msg.body.reason + "]" : ""), pfc.appendMessage(msg), pfc.removeUser(kicked.id))
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.commands = $.extend({}, pfc.commands), pfc.commands.op = {
            help: "gives operator rights to a user on a channel",
            usage: '/op "<username>"',
            longusage: '/op ["#<channel>"] "<username>"',
            params: ["channel", "username"],
            regexp: [/^("#(.+?)" |)"(.+?)"$/],
            regexp_ids: [{
                2: "channel",
                3: "username"
            }],
            send: function(cmd_arg) {
                var uid = pfc.getUidFromName(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/op/" + uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "PUT"
                    } : null
                }).done(function() {
                    pfc.commands.op.receive({
                        type: "op",
                        sender: pfc.uid,
                        body: uid,
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    op = pfc.users[msg.sender],
                    op_dst = pfc.users[msg.body];
                pfc.addUidToCidOp(op_dst.id, cid), msg.body = op.name + " gave operator rights to " + op_dst.name, pfc.appendMessage(msg), pfc.removeUser(op_dst.id), pfc.appendUser(op_dst.id)
            }
        }, pfc.commands.deop = {
            help: "removes operator rights to a user on a channel",
            usage: '/deop "<username>"',
            longusage: '/deop ["#<channel>"] "<username>"',
            params: ["channel", "username"],
            regexp: [/^("#(.+?)" |)"(.+?)"$/],
            regexp_ids: [{
                2: "channel",
                3: "username"
            }],
            send: function(cmd_arg) {
                var uid = pfc.getUidFromName(cmd_arg.username);
                $.ajax({
                    type: pfc.options.use_post_wrapper ? "POST" : "DELETE",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/op/" + uid,
                    data: pfc.options.use_post_wrapper ? {
                        _METHOD: "DELETE"
                    } : null
                }).done(function() {
                    pfc.commands.deop.receive({
                        type: "deop",
                        sender: pfc.uid,
                        body: uid,
                        recipient: "channel|" + cmd_arg.cid
                    })
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                var cid = msg.recipient.split("|")[1],
                    deop = pfc.users[msg.sender],
                    deop_dst = pfc.users[msg.body];
                pfc.removeUidFromCidOp(deop_dst.id, cid), msg.body = deop.name + " removed operator rights to " + deop_dst.name, pfc.appendMessage(msg), pfc.removeUser(deop_dst.id), pfc.appendUser(deop_dst.id)
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.commands = $.extend({}, pfc.commands), pfc.commands.msg = {
            usage: '/msg "<message>"',
            longusage: '/msg ["#<channel>"] "<message>"',
            regexp: [/^("#(.+?)" |)"(.+?)"$/],
            regexp_ids: [{
                2: "channel",
                3: "message"
            }],
            send: function(cmd_arg) {
                $.ajax({
                    type: "POST",
                    url: pfc.options.serverUrl + "/channels/" + cmd_arg.cid + "/msg/",
                    contentType: "application/json; charset=utf-8",
                    data: JSON.stringify(cmd_arg.message)
                }).done(function(msg) {
                    pfc.commands.msg.receive(msg)
                }).error(function(err) {
                    console.log(err)
                })
            },
            receive: function(msg) {
                pfc.appendMessage(msg)
            }
        }, pfc.parseCommand = function(raw) {
            var cmd = "",
                cmd_arg = null;
            if ($.each(pfc.commands, function(c) {
                    if (RegExp("^/" + c + "( |$)").test(raw)) {
                        cmd = c;
                        var raw_end = RegExp("^/" + c + " *(.*)$").exec(raw)[1];
                        $.each(pfc.commands[c].regexp, function(i, regexp) {
                            var cmd_arg_tmp = regexp.exec(raw_end);
                            null === cmd_arg && cmd_arg_tmp && cmd_arg_tmp.length > 0 && (cmd_arg = {}, $.each(pfc.commands[c].regexp_ids[i], function(id, key) {
                                cmd_arg[key] = cmd_arg_tmp[id]
                            }))
                        })
                    }
                }), "" === cmd && (cmd = "msg", cmd_arg = {
                    cid: pfc.cid,
                    message: raw
                }), null === cmd_arg) throw [cmd, pfc.commands[cmd].usage];
            return cmd_arg.cid || (cmd_arg.cid = cmd_arg.channel ? pfc.getCidFromName(cmd_arg.channel) : pfc.cid), [cmd, cmd_arg]
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $, window, undefined) {
        return pfc.readPendingMessages = function(loop) {
            pfc.readPendingMessages.nb_network_error === undefined && (pfc.readPendingMessages.nb_network_error = 0), $.ajax({
                type: "GET",
                url: pfc.options.serverUrl + "/users/" + pfc.uid + "/pending/"
            }).done(function(msgs) {
                pfc.readPendingMessages.nb_network_error = 0, $.each(msgs, function(i, m) {
                    pfc.commands[m.type] !== undefined ? pfc.commands[m.type].receive(m) : pfc.showErrorsPopup(["Unknown command " + m.type])
                }), loop && setTimeout(function() {
                    pfc.readPendingMessages(!0)
                }, pfc.options.refresh_delay)
            }).error(function() {
                pfc.readPendingMessages.nb_network_error++ > pfc.options.tolerated_network_errors ? pfc.showErrorsPopup(["Network error. Please reload the chat to continue."]) : loop && setTimeout(function() {
                    pfc.readPendingMessages(!0)
                }, pfc.options.refresh_delay)
            })
        }, pfc.join = function() {
            pfc.postCommand('/join "#xxx"')
        }, pfc.leave = function() {
            pfc.postCommand('/leave "#xxx"')
        }, pfc.postCommand = function(raw_cmd) {
            if ("" === raw_cmd) return !1;
            try {
                var cmd = pfc.parseCommand(raw_cmd);
                pfc.commands[cmd[0]].send(cmd[1])
            } catch (err) {
                pfc.appendMessage({
                    from: "system-error",
                    body: "Invalid command syntax. Usage:\n" + err[1]
                })
            }
        }, pfc.notifyThatWindowIsClosed = function() {
            $.ajax({
                type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                async: !1,
                url: pfc.options.serverUrl + "/users/" + pfc.uid + "/closed",
                data: pfc.options.use_post_wrapper ? {
                    _METHOD: "PUT"
                } : "1"
            }).done(function() {}).error(function(err) {
                console.log(err)
            })
        }, pfc.appendUser = function(user) {
            pfc.users[user] && (user = pfc.users[user]), user.id = user.id !== undefined ? user.id : 0, user.op = $.inArray(user.id, pfc.channels[pfc.cid].op) >= 0, user.role = user.op ? "admin" : "user", user.name = user.name !== undefined ? user.name : "Guest " + Math.round(100 * Math.random()), user.email = user.email !== undefined ? user.email : "", user.active = user.active !== undefined ? user.active : !0;
            var users_dom = $(pfc.element).find("admin" == user.role ? "div.pfc-role-admin" : "div.pfc-role-user"),
                html = $('              <li class="user">                <div class="status"></div>                <div class="name"></div>                <div class="avatar"></div>              </li>');
            user.name && html.find("div.name").text(user.name), 0 === users_dom.find("li").length && html.addClass("first"), html.find("div.status").addClass(user.active ? "st-active" : "st-inactive"), user.op && html.find("div.status").addClass("st-op");
            var userids = [];
            if ($(pfc.element).find("div.pfc-users li.user").each(function(i, dom_user) {
                    userids.push(parseInt($(dom_user).attr("id").split("_")[1], 10))
                }), 0 === user.id)
                do user.id = Math.round(1e4 * Math.random()); while (-1 !== $.inArray(user.id, userids));
            return 0 === user.id || -1 !== $.inArray(user.id, userids) ? 0 : (html.attr("id", "user_" + user.id), users_dom.find("ul").append(html), pfc.updateRolesTitles(), user.id)
        }, pfc.removeUser = function(uid) {
            var removed = $(pfc.element).find("#user_" + uid).remove().length > 0;
            return pfc.updateRolesTitles(), removed
        }, pfc.updateRolesTitles = function() {
            [$(pfc.element).find("div.pfc-role-admin"), $(pfc.element).find("div.pfc-role-user")].forEach(function(item) {
                0 === item.find("li").length ? item.find(".role-title").hide() : item.find(".role-title").show()
            })
        }, pfc.clearUserList = function() {
            return $(pfc.element).find("li.user").remove(), pfc.updateRolesTitles(), !0
        }, pfc.appendMessage = function(msg) {
            msg.from = "msg" == msg.type ? msg.sender : msg.from !== undefined ? msg.from : "system-message", msg.name = pfc.users[msg.sender] !== undefined ? pfc.users[msg.sender].name : msg.name, msg.body = msg.body !== undefined ? msg.body : "", msg.timestamp = msg.timestamp !== undefined ? msg.timestamp : Math.round((new Date).getTime() / 1e3), msg.date = new Date(1e3 * msg.timestamp).toLocaleTimeString(), "join" == msg.type ? msg.body = msg.name + " joined the channel" : "leave" == msg.type && (msg.body = msg.name + " left the channel" + (msg.body ? " (" + msg.body + ")" : ""));
            var groupmsg_dom = $(pfc.element).find(".pfc-messages .messages-group:last"),
                messages_dom = $(pfc.element).find(".pfc-messages"),
                html = null;
            groupmsg_dom.attr("data-from") != msg.from && (html = $('<div class="messages-group" data-stamp="" data-from="">       <div class="date"></div>       <div class="name"></div>     </div>'), /^system-/.test(msg.from) && (html.addClass("from-" + msg.from), html.find(".name").remove(), html.find(".avatar").remove()), html.find(".name").text(msg.name), html.attr("data-from", msg.from), html.find(".date").text(msg.date), html.attr("data-stamp", msg.timestamp), messages_dom.append(html), groupmsg_dom = html), msg.body = $("<pre></pre>").text(msg.body).html();
            var message = $('<div class="message"></div>').html(msg.body);
            return groupmsg_dom.append(message), groupmsg_dom == html ? messages_dom.scrollTop(messages_dom.scrollTop() + groupmsg_dom.outerHeight() + 10) : messages_dom.scrollTop(messages_dom.scrollTop() + message.outerHeight()), message
        }, pfc.setTopic = function(topic) {
            $(pfc.element).find(".pfc-topic-value").text(topic)
        }, pfc.showDonationPopup = function(next) {
            function buildAndShowDonationPopup() {

                // var box = pfc.modalbox.open('<form class="popup-donate">  <p>phpFreeChat is an adventure we have been sharing altogether since 2006.     If this chat is a so successfull, with hundreds of daily downloads,     it is thanks to those who have been helping the project financially.     Keep making this adventure possible, make a donation. Thank you.  </p>  <div clalss="bt-validate">    <input type="submit" name="cancel-donate" value="not now" />    <input type="submit" name="ok-donate" value="DONATE" />  </div>  <span><label><input type="checkbox" name="skip-donate" /> skip next time</label></span></form>');
                // box.find("input[name=ok-donate]").focus();
                // var esc_key_action = function(event) {
                //     27 == event.which && (pfc.modalbox.close(!0), $(document).off("keyup", esc_key_action), next())
                // };
                // $(document).on("keyup", esc_key_action), box.find("input[type=submit]").click(function() {
                //     "ok-donate" == $(this).attr("name") && window.open("http://www.phpfreechat.net/donate", "pfc-donate"), box.find("input[name=skip-donate]").attr("checked") && $.ajax({
                //         type: pfc.options.use_post_wrapper ? "POST" : "PUT",
                //         url: pfc.options.serverUrl + "/skipintro",
                //         data: pfc.options.use_post_wrapper ? {
                //             _METHOD: "PUT"
                //         } : 1
                //     }).done(function() {}).error(function() {}), pfc.modalbox.close(!0), $(document).off("keyup", esc_key_action), next()
                // }), box.submit(function(evt) {
                //     evt.preventDefault()
                // })
            }
            return pfc.options.skip_intro ? (next(), undefined) : ($.ajax({
                type: "GET",
                url: pfc.options.serverUrl + "/skipintro"
            }).complete(function(jqXHR) {
                200 != jqXHR.status ? buildAndShowDonationPopup() : next()
            }), undefined)
        }, pfc.displayError = function(err) {
            switch (err = err.responseText ? JSON.parse(err.responseText) : {
                error: err.statusText,
                errorCode: err.status
            }, err.errorCode) {
                case 40305:
                    err.baninfo.timestamp = new Date(1e3 * err.baninfo.timestamp), pfc.appendMessage({
                        type: "error",
                        body: "You cannot join this channel because you have been banned by " + err.baninfo.opname + " for " + (err.baninfo.reason ? 'the reason "' + err.baninfo.reason + '"' : "no reason") + " on " + err.baninfo.timestamp
                    });
                    break;
                default:
                    pfc.appendMessage({
                        type: "error",
                        body: err.error + " [" + err.errorCode + "]"
                    })
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $, window) {
        return pfc.init = function(plugin) {
            pfc.element = plugin.element, pfc.options = plugin.options, pfc.users = {}, pfc.channels = {}, pfc.uid = null, pfc.cid = null, (!pfc.options.check_backlink || pfc.hasBacklink()) && (pfc.loadHTML(), pfc.loadResponsiveBehavior(), pfc.checkServerConfig(pfc.startChatLogic))
        }, pfc.checkServerConfig = function(next) {
            pfc.options.check_server_config ? pfc.checkServerConfigPHP(function() {
                pfc.checkServerConfigRewrite(next)
            }) : next()
        }, pfc.checkServerConfigPHP = function(next) {
            $.ajax({
                type: "GET",
                url: pfc.options.serverCheckUrl
            }).done(function(errors) {
                try {
                    errors instanceof String && (errors = JSON.parse(errors))
                } catch (err) {
                    errors = [errors]
                }
                errors && errors.length > 0 ? pfc.showErrorsPopup(errors) : next()
            }).error(function() {
                pfc.showErrorsPopup(["Unknown error: check.php cannot be found"])
            })
        }, pfc.checkServerConfigRewrite = function(next) {
            var err_rewrite_msg = 'mod_rewrite must be enabled server side and correctly configured. "RewriteBase" could be adjusted in server/.htaccess file.';
            $.ajax({
                type: "GET",
                url: pfc.options.serverUrl + "/status"
            }).done(function(status) {
                status && status.running ? next() : pfc.showErrorsPopup([err_rewrite_msg])
            }).error(function() {
                pfc.showErrorsPopup([err_rewrite_msg])
            })
        }, pfc.startChatLogic = function() {
            pfc.showDonationPopup(function() {
                pfc.options.skip_auth || pfc.login()
            }), $(pfc.element).bind("pfc-login", function(evt, pfc, userdata) {
                pfc.uid = userdata.id, pfc.users[userdata.id] = userdata, pfc.cid = "xxx", pfc.options.focus_on_connect && $("div.pfc-compose textarea").focus(), pfc.readPendingMessages(!0), pfc.join(pfc.cid)
            }), $(pfc.element).bind("pfc-logout", function(evt, pfc) {
                pfc.uid = null, pfc.clearUserList()
            })
        }, pfc.hasBacklink = function() {
            var backlink = 10;$('a[href="http://www.phpfreechat.net"]').length;
            return backlink ? !0 : ($(pfc.element).html('<div class="pfc-backlink"><p>Please insert the phpfreechat backlink somewhere in your HTML in order to load the chat. The attended backlink is:</p><pre>' + $("<div/>").text('<a href="http://www.phpfreechat.net">phpFreeChat: simple Web chat</a>').html() + "</pre>" + "</div>"), !1)
        }, pfc.loadHTML = function() {
            $(pfc.element).html((pfc.options.loadTestData ? '      <div class="pfc-content">' : '      <div class="pfc-content pfc-notabs">') + '        <div class="pfc-tabs">' + "          <ul>" + (pfc.options.loadTestData ? '            <li class="channel active">              <div class="icon"></div>              <div class="name">Channel 1</div>              <div class="close"></div>            </li>            <li class="channel">              <div class="icon"></div>              <div class="name">Channel 2</div>              <div class="close"></div>            </li>            <li class="pm">              <div class="icon"></div>              <div class="name">admin</div>              <div class="close"></div>            </li>            <li class="new-tab">              <div class="icon"></div>            </li>' : "") + "          </ul>" + "        </div>" + '        <div class="pfc-topic">' + '          <a class="pfc-toggle-tabs"></a>' + '          <p><span class="pfc-topic-label">Topic:</span> <span class="pfc-topic-value">no topic for this channel</span></p>' + '          <a class="pfc-toggle-users"></a>' + "        </div>" + '        <div class="pfc-messages">' + '          <div class="pfc-message-mobile-padding"></div>' + (pfc.options.loadTestData ? '          <div class="messages-group" data-stamp="1336815502" data-from="kerphi">            <div class="avatar"><img src="http://www.gravatar.com/avatar/ae5979732c49cae7b741294a1d3a8682?d=wavatar&s=30" alt="" /></div>            <div class="date">11:38:21</div>            <div class="name">kerphi</div>            <div class="message">123 <a href="#">test de lien</a></div>            <div class="message">456</div>          </div>          <div class="messages-group" data-stamp="1336815503" data-from="admin">            <div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000001?d=wavatar&s=30" alt="" /></div>            <div class="date">11:38:22</div>            <div class="name">admin</div>            <div class="message">Hello</div>            <div class="message">World</div>            <div class="message">!</div>            <div class="message">A very very very very very very very very very very very very very very very very very very very long text</div>          </div>' : "") + "        </div>" + '        <div class="pfc-users">' + '          <div class="pfc-role-admin">' + '            <p class="role-title">Administrators</p>' + "            <ul>" + (pfc.options.loadTestData ? '              <li class="first">                <div class="status st-active"></div>                <div class="name">admin</div>                <div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000001?d=wavatar&s=20" alt="" /></div>              </li>' : "") + "            </ul>" + "          </div>" + '          <div class="pfc-role-user">' + '            <p class="role-title">Users</p>' + "            <ul>" + (pfc.options.loadTestData ? '              <li class="first">                <div class="status st-active"></div>                <div class="name myself">kerphi</div>                <div class="avatar"><img src="http://www.gravatar.com/avatar/ae5979732c49cae7b741294a1d3a8682?d=wavatar&s=20" alt="" /></div>              </li>              <li>                <div class="status st-inactive"></div>                <div class="name">Stéphane Gully</div>                <div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000002?d=wavatar&s=20" alt="" /></div>              </li>' : "") + "            </ul>" + "          </div>" + "        </div>" + '        <div class="pfc-footer">' + (pfc.options.show_powered_by ? '          <p class="logo"><a href="http://www.phpfreechat.net" class="bt-powered" target="_blank">Powered by phpFreeChat</a><a href="http://www.phpfreechat.net/donate" class="bt-donate" title="Phpfreechat is for you and needs you" target="_blank">Donate</a></p>' : "") + (pfc.options.loadTestData ? '          <p class="ping">150ms</p>          <ul>            <li><div class="logout-btn" title="Logout"></div></li>            <li><div class="smiley-btn" title="Not implemented"></div></li>            <li><div class="sound-btn" title="Not implemented"></div></li>            <li><div class="online-btn"></div></li>          </ul>' : "") + "        </div>" + '        <div class="pfc-compose">' + '          <textarea data-to="channel|xxx"></textarea>' + "        </div>" + '        <div class="pfc-modal-overlay"></div>' + '        <div class="pfc-modal-box"></div>' + '        <div class="pfc-ad-desktop"></div>' + '        <div class="pfc-ad-tablet"></div>' + '        <div class="pfc-ad-mobile"></div>' + "      </div>"), pfc.options.show_powered_by && $.ajax({
                type: "GET",
                url: pfc.options.packageUrl
            }).done(function(p) {
                if ("string" == typeof p) try {
                    p = JSON.parse(p)
                } catch (err) {}
                p.version && $(pfc.element).find("p.logo a.bt-powered").attr("title", "version " + p.version)
            }), $(".pfc-compose textarea").keydown(function(evt) {
                return 13 == evt.keyCode && evt.shiftKey === !1 ? (pfc.postCommand($(".pfc-compose textarea").val()), $(".pfc-compose textarea").val(""), !1) : undefined
            }), $(window).resize(function() {
                var textarea_border_width = parseInt($(".pfc-compose textarea").css("border-right-width"), 10),
                    textarea_padding = parseInt($(".pfc-compose textarea").css("padding-right"), 10) + parseInt($(".pfc-compose textarea").css("padding-left"), 10);
                $(".pfc-compose textarea").width($(".pfc-compose").innerWidth() - 2 * textarea_border_width - textarea_padding)
            }), $(window).unload(function() {
                pfc.notifyThatWindowIsClosed()
            }), pfc.modalbox.init(), pfc.options.loaded && pfc.options.loaded(pfc), setTimeout(function() {
                $(pfc.element).trigger("pfc-loaded", [pfc])
            }, 0)
        }, pfc.showErrorsPopup = function(errors) {
            var popup = $('<ul class="pfc-errors"></ul>');
            $.each(errors, function(i, err) {
                popup.append($("<li></li>").html(err))
            }), pfc.modalbox.open(popup)
        }, pfc.loadResponsiveBehavior = function() {
            function switchTabsToMobileLook() {
                elt_tabs.removeClass("pfc-tabs").addClass("pfc-mobile-tabs"), elt_tabs.hide(), 1 == tab_slide_status && (slideTabsUp(), tab_slide_status = 0)
            }

            function switchTabsToDesktopLook() {
                elt_tabs.addClass("pfc-tabs").removeClass("pfc-mobile-tabs"), elt_tabs.show(), 1 == tab_slide_status && (slideTabsUp(), tab_slide_status = 0)
            }

            function slideTabsUp(withtabs) {
                withtabs && elt_tabs.slideUp(500), elt_messages.animate({
                    top: "-=" + height_slidetabs
                }, 500), elt_users.animate({
                    top: "-=" + height_slidetabs
                }, 500)
            }

            function slideTabsDown(withtabs) {
                withtabs && elt_tabs.slideDown(500), elt_messages.animate({
                    top: "+=" + height_slidetabs
                }, 500), elt_users.animate({
                    top: "+=" + height_slidetabs
                }, 500)
            }

            function switchUsersToMobileLook() {
                elt_users.hide()
            }

            function switchUsersToDesktopLook() {
                elt_users.css("width", width_users + "px").show()
            }

            function scrollMessagesToBottom() {
                var messages_dom = $(pfc.element).find(".pfc-messages"),
                    messages_height = 0;
                messages_dom.each(function(i, elt) {
                    messages_height += $(elt).height()
                }), messages_dom.scrollTop(messages_dom.scrollTop() + messages_height)
            }
            var elt_tabs = $(".pfc-tabs"),
                elt_users = $(".pfc-users"),
                elt_messages = $(".pfc-messages"),
                height_slidetabs = elt_tabs.height(),
                width_users = elt_users.width(),
                tab_slide_status = 0,
                elt_toggle_tabs_btn = $("a.pfc-toggle-tabs"),
                elt_toggle_users_btn = $("a.pfc-toggle-users");
            $(window).resize(function() {
                elt_toggle_tabs_btn.is(":visible") ? (switchTabsToMobileLook(), scrollMessagesToBottom()) : switchTabsToDesktopLook(), elt_toggle_users_btn.is(":visible") ? (switchUsersToMobileLook(), scrollMessagesToBottom()) : switchUsersToDesktopLook()
            }), elt_toggle_tabs_btn.click(function() {
                elt_tabs.removeClass("pfc-tabs").addClass("pfc-mobile-tabs"), height_slidetabs = elt_tabs.height(), elt_tabs.is(":visible") ? (tab_slide_status = 0, slideTabsUp(!0)) : (tab_slide_status = 1, slideTabsDown(!0))
            }), elt_toggle_users_btn.click(function() {
                elt_users.is(":visible") ? (elt_users.animate({
                    width: "-=" + width_users
                }, 500), setTimeout(function() {
                    elt_users.hide()
                }, 500)) : (elt_users.css("width", "0px").show(), elt_users.animate({
                    width: "+=" + width_users
                }, 500))
            })
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $) {
        return pfc.getUidFromName = function(name) {
            var result = null;
            return $.each(pfc.users, function(uid, user) {
                name === user.name && (result = uid)
            }), result
        }, pfc
    }(phpFreeChat || {}, jQuery, window),
    phpFreeChat = function(pfc, $, window) {
        jQuery = $, pfc.md5 = function(s) {
            function L(k, d) {
                return k << d | k >>> 32 - d
            }

            function K(G, k) {
                var I, d, F, H, x;
                return F = 2147483648 & G, H = 2147483648 & k, I = 1073741824 & G, d = 1073741824 & k, x = (1073741823 & G) + (1073741823 & k), I & d ? 2147483648 ^ x ^ F ^ H : I | d ? 1073741824 & x ? 3221225472 ^ x ^ F ^ H : 1073741824 ^ x ^ F ^ H : x ^ F ^ H
            }

            function r(d, F, k) {
                return d & F | ~d & k
            }

            function q(d, F, k) {
                return d & k | F & ~k
            }

            function p(d, F, k) {
                return d ^ F ^ k
            }

            function n(d, F, k) {
                return F ^ (d | ~k)
            }

            function u(G, F, aa, Z, k, H, I) {
                return G = K(G, K(K(r(F, aa, Z), k), I)), K(L(G, H), F)
            }

            function f(G, F, aa, Z, k, H, I) {
                return G = K(G, K(K(q(F, aa, Z), k), I)), K(L(G, H), F)
            }

            function D(G, F, aa, Z, k, H, I) {
                return G = K(G, K(K(p(F, aa, Z), k), I)), K(L(G, H), F)
            }

            function t(G, F, aa, Z, k, H, I) {
                return G = K(G, K(K(n(F, aa, Z), k), I)), K(L(G, H), F)
            }

            function e(G) {
                for (var Z, F = G.length, x = F + 8, k = (x - x % 64) / 64, I = 16 * (k + 1), aa = Array(I - 1), d = 0, H = 0; F > H;) Z = (H - H % 4) / 4, d = 8 * (H % 4), aa[Z] = aa[Z] | G.charCodeAt(H) << d, H++;
                return Z = (H - H % 4) / 4, d = 8 * (H % 4), aa[Z] = aa[Z] | 128 << d, aa[I - 2] = F << 3, aa[I - 1] = F >>> 29, aa
            }

            function B(x) {
                var G, d, k = "",
                    F = "";
                for (d = 0; 3 >= d; d++) G = 255 & x >>> 8 * d, F = "0" + G.toString(16), k += F.substr(F.length - 2, 2);
                return k
            }

            function J(k) {
                k = k.replace(/rn/g, "n");
                for (var d = "", F = 0; k.length > F; F++) {
                    var x = k.charCodeAt(F);
                    128 > x ? d += String.fromCharCode(x) : x > 127 && 2048 > x ? (d += String.fromCharCode(192 | x >> 6), d += String.fromCharCode(128 | 63 & x)) : (d += String.fromCharCode(224 | x >> 12), d += String.fromCharCode(128 | 63 & x >> 6), d += String.fromCharCode(128 | 63 & x))
                }
                return d
            }
            var P, h, E, v, g, Y, X, W, V, C = [],
                S = 7,
                Q = 12,
                N = 17,
                M = 22,
                A = 5,
                z = 9,
                y = 14,
                w = 20,
                o = 4,
                m = 11,
                l = 16,
                j = 23,
                U = 6,
                T = 10,
                R = 15,
                O = 21;
            for (s = J(s), C = e(s), Y = 1732584193, X = 4023233417, W = 2562383102, V = 271733878, P = 0; C.length > P; P += 16) h = Y, E = X, v = W, g = V, Y = u(Y, X, W, V, C[P + 0], S, 3614090360), V = u(V, Y, X, W, C[P + 1], Q, 3905402710), W = u(W, V, Y, X, C[P + 2], N, 606105819), X = u(X, W, V, Y, C[P + 3], M, 3250441966), Y = u(Y, X, W, V, C[P + 4], S, 4118548399), V = u(V, Y, X, W, C[P + 5], Q, 1200080426), W = u(W, V, Y, X, C[P + 6], N, 2821735955), X = u(X, W, V, Y, C[P + 7], M, 4249261313), Y = u(Y, X, W, V, C[P + 8], S, 1770035416), V = u(V, Y, X, W, C[P + 9], Q, 2336552879), W = u(W, V, Y, X, C[P + 10], N, 4294925233), X = u(X, W, V, Y, C[P + 11], M, 2304563134), Y = u(Y, X, W, V, C[P + 12], S, 1804603682), V = u(V, Y, X, W, C[P + 13], Q, 4254626195), W = u(W, V, Y, X, C[P + 14], N, 2792965006), X = u(X, W, V, Y, C[P + 15], M, 1236535329), Y = f(Y, X, W, V, C[P + 1], A, 4129170786), V = f(V, Y, X, W, C[P + 6], z, 3225465664), W = f(W, V, Y, X, C[P + 11], y, 643717713), X = f(X, W, V, Y, C[P + 0], w, 3921069994), Y = f(Y, X, W, V, C[P + 5], A, 3593408605), V = f(V, Y, X, W, C[P + 10], z, 38016083), W = f(W, V, Y, X, C[P + 15], y, 3634488961), X = f(X, W, V, Y, C[P + 4], w, 3889429448), Y = f(Y, X, W, V, C[P + 9], A, 568446438), V = f(V, Y, X, W, C[P + 14], z, 3275163606), W = f(W, V, Y, X, C[P + 3], y, 4107603335), X = f(X, W, V, Y, C[P + 8], w, 1163531501), Y = f(Y, X, W, V, C[P + 13], A, 2850285829), V = f(V, Y, X, W, C[P + 2], z, 4243563512), W = f(W, V, Y, X, C[P + 7], y, 1735328473), X = f(X, W, V, Y, C[P + 12], w, 2368359562), Y = D(Y, X, W, V, C[P + 5], o, 4294588738), V = D(V, Y, X, W, C[P + 8], m, 2272392833), W = D(W, V, Y, X, C[P + 11], l, 1839030562), X = D(X, W, V, Y, C[P + 14], j, 4259657740), Y = D(Y, X, W, V, C[P + 1], o, 2763975236), V = D(V, Y, X, W, C[P + 4], m, 1272893353), W = D(W, V, Y, X, C[P + 7], l, 4139469664), X = D(X, W, V, Y, C[P + 10], j, 3200236656), Y = D(Y, X, W, V, C[P + 13], o, 681279174), V = D(V, Y, X, W, C[P + 0], m, 3936430074), W = D(W, V, Y, X, C[P + 3], l, 3572445317), X = D(X, W, V, Y, C[P + 6], j, 76029189), Y = D(Y, X, W, V, C[P + 9], o, 3654602809), V = D(V, Y, X, W, C[P + 12], m, 3873151461), W = D(W, V, Y, X, C[P + 15], l, 530742520), X = D(X, W, V, Y, C[P + 2], j, 3299628645), Y = t(Y, X, W, V, C[P + 0], U, 4096336452), V = t(V, Y, X, W, C[P + 7], T, 1126891415), W = t(W, V, Y, X, C[P + 14], R, 2878612391), X = t(X, W, V, Y, C[P + 5], O, 4237533241), Y = t(Y, X, W, V, C[P + 12], U, 1700485571), V = t(V, Y, X, W, C[P + 3], T, 2399980690), W = t(W, V, Y, X, C[P + 10], R, 4293915773), X = t(X, W, V, Y, C[P + 1], O, 2240044497), Y = t(Y, X, W, V, C[P + 8], U, 1873313359), V = t(V, Y, X, W, C[P + 15], T, 4264355552), W = t(W, V, Y, X, C[P + 6], R, 2734768916), X = t(X, W, V, Y, C[P + 13], O, 1309151649), Y = t(Y, X, W, V, C[P + 4], U, 4149444226), V = t(V, Y, X, W, C[P + 11], T, 3174756917), W = t(W, V, Y, X, C[P + 2], R, 718787259), X = t(X, W, V, Y, C[P + 9], O, 3951481745), Y = K(Y, h), X = K(X, E), W = K(W, v), V = K(V, g);
            var i = B(Y) + B(X) + B(W) + B(V);
            return i.toLowerCase()
        };
        var Base64 = {
            _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
            encode: function(e) {
                var n, r, i, s, o, u, a, t = "",
                    f = 0;
                for (e = Base64._utf8_encode(e); e.length > f;) n = e.charCodeAt(f++), r = e.charCodeAt(f++), i = e.charCodeAt(f++), s = n >> 2, o = (3 & n) << 4 | r >> 4, u = (15 & r) << 2 | i >> 6, a = 63 & i, isNaN(r) ? u = a = 64 : isNaN(i) && (a = 64), t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a);
                return t
            },
            decode: function(e) {
                var n, r, i, s, o, u, a, t = "",
                    f = 0;
                for (e = e.replace(/[^A-Za-z0-9\+\/\=]/g, ""); e.length > f;) s = this._keyStr.indexOf(e.charAt(f++)), o = this._keyStr.indexOf(e.charAt(f++)), u = this._keyStr.indexOf(e.charAt(f++)), a = this._keyStr.indexOf(e.charAt(f++)), n = s << 2 | o >> 4, r = (15 & o) << 4 | u >> 2, i = (3 & u) << 6 | a, t += String.fromCharCode(n), 64 != u && (t += String.fromCharCode(r)), 64 != a && (t += String.fromCharCode(i));
                return t = Base64._utf8_decode(t)
            },
            _utf8_encode: function(e) {
                e = e.replace(/\r\n/g, "\n");
                for (var t = "", n = 0; e.length > n; n++) {
                    var r = e.charCodeAt(n);
                    128 > r ? t += String.fromCharCode(r) : r > 127 && 2048 > r ? (t += String.fromCharCode(192 | r >> 6), t += String.fromCharCode(128 | 63 & r)) : (t += String.fromCharCode(224 | r >> 12), t += String.fromCharCode(128 | 63 & r >> 6), t += String.fromCharCode(128 | 63 & r))
                }
                return t
            },
            _utf8_decode: function(e) {
                for (var t = "", n = 0, r = c1 = c2 = 0; e.length > n;) r = e.charCodeAt(n), 128 > r ? (t += String.fromCharCode(r), n++) : r > 191 && 224 > r ? (c2 = e.charCodeAt(n + 1), t += String.fromCharCode((31 & r) << 6 | 63 & c2), n += 2) : (c2 = e.charCodeAt(n + 1), c3 = e.charCodeAt(n + 2), t += String.fromCharCode((15 & r) << 12 | (63 & c2) << 6 | 63 & c3), n += 3);
                return t
            }
        };
        return pfc.base64 = Base64, pfc.modalbox = {
            open: function(html) {
                return html = $(html), $("div.pfc-modal-box *").remove(), $("div.pfc-modal-box").append(html).fadeIn(), $.browser.msie ? $("div.pfc-modal-overlay").show() : $("div.pfc-modal-overlay").fadeIn("fast"), $(window).trigger("resize"), html
            },
            close: function(now) {
                now ? ($("div.pfc-modal-box").hide(), $("div.pfc-modal-overlay").hide()) : ($("div.pfc-modal-box").fadeOut(), $("div.pfc-modal-overlay").fadeOut("fast"))
            },
            init: function() {
                $(window).resize(function() {
                    var mb = $("div.pfc-modal-box"),
                        mo = $("div.pfc-modal-overlay");
                    mb.css({
                        left: (mo.outerWidth(!0) - mb.outerWidth(!0)) / 2,
                        top: (mo.outerHeight(!0) - mb.outerHeight(!0)) / 2
                    })
                }).trigger("resize")
            }
        }, pfc
    }(phpFreeChat || {}, jQuery, window);